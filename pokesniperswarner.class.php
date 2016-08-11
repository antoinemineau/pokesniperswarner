<?php

require_once('colors.class.php');

class PokeSnipersWarner {
	private $apiUrl = 'http://pokesnipers.com/api/v1/pokemon.json';
	private $iv = 90;
	private $timer = 15;
	private $beepCount = 5;
	private $pokemonFound = array();

	public function __construct($iv, $timer)
	{
		$this->iv = ($iv !== null) ? (int)$iv : $this->iv;
		$this->timer = ($timer !== null && $timer >= 15) ? (int)$timer : $this->timer;
		$this->colors = new Colors();
	}

	public function loop()
	{
		while (true) {
			$this->call();
			sleep($this->timer);
		}
	}

	private function beep()
	{
		for ($x = 0; $x != $this->beepCount; $x++) {
			echo "\x07";
		}
	}

	private function call()
	{
		$results = file_get_contents($this->apiUrl);
		$json = json_decode($results, true);
		$found = 0;
		$time = date('Y-m-d H:i:s');

		if (isset($json['results'])) {
			foreach ($json['results'] as $row) {
				if ($row['iv'] >= $this->iv && !in_array($row['id'], $this->pokemonFound)) {
					$this->pokemonFound[] = $row['id'];
					$coords = explode(',', $row['coords']);
					$this->colors->display("/!\\/!\\/!\\/!\\/!\\/!\\ POKEMON FOUND - {$time} /!\\/!\\/!\\/!\\/!\\/!\\", "white", "blue");
					$this->colors->display("{$row['name']} with IV {$row['iv']}", "cyan");
					$this->colors->display("longitude: {$coords[0]}", "green");
					$this->colors->display("latitude: {$coords[1]}", "green");
					$this->colors->display("until: {$row['until']}", "green");
					foreach ($row['attacks'] as $attack) {
						if ($attack != null) {
							$this->colors->display("attack: {$attack}", "yellow");
						}
					}
					$found++;
				}
			}

			if ($found == 0) {
				$this->colors->display("No pokemon found with IV {$this->iv} at {$time} :'(", "white", "red");
			} else {
				$this->beep();
			}
		} else {
			$this->writer("Impossible to parse the API at {$time} :'(", "white", "red");
		}
	}
}

$pokeSnipersWarner = new PokeSnipersWarner($argv[1], $argv[2]);
$pokeSnipersWarner->loop();
?>
