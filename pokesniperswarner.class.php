<?php

require_once('colors.class.php');

class PokeSniperWarner {
	private $apiUrl = 'http://pokesnipers.com/api/v1/pokemon.json';
	private $iv = 90;
	private $timer = 20;
	private $colors;

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

	private function call()
	{
		$results = file_get_contents($this->apiUrl);
		$json = json_decode($results, true);
		$found = 0;

		if (isset($json['results'])) {
			foreach ($json['results'] as $row) {
				if ($row['iv'] >= $this->iv) {
					$coords = explode(',', $row['coords']);
					$this->colors->display("/!\\/!\\/!\\/!\\/!\\/!\\ POKEMON FOUND /!\\/!\\/!\\/!\\/!\\/!\\", "white", "blue");
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
				$this->colors->display("No pokemon found with IV {$this->iv} :'(", "white", "red");
			}
		} else {
			$this->writer("Impossible to parse the API :'(", "white", "red");
		}
	}
}

$pokeSniperWarner = new PokeSniperWarner($argv[1], $argv[2]);
$pokeSniperWarner->loop();
?>