<?php

const IV = 90;

function main()
{
	while(1) {
		warner();
		sleep(20);
   	}
}

function warner()
{
	echo 'API CALL'. "\r\n";
	$results = file_get_contents('http://pokesnipers.com/api/v1/pokemon.json');
	$json = json_decode($results, true);

	foreach ($json as $row) {
		if ($row['iv'] >= IV) {
			var_dump($row);
        }
    }
}

main();
