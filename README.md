# PokeSnipersWarner
Php class that calls http://pokesnipers.com API and warns you when finding powerful pokemons :

![PokeSnipersWarner screenshot](https://raw.githubusercontent.com/antoinemineau/pokesniperswarner/master/examples/screenshot.png)


Launch
======

	php pokesniperswarner.class.php


By default it warns you when finding pokemon with IV >= 90 and it calls the API every 15 seconds.


You can change those values by adding arguments to the launcher :

* First argument is IV
* Second argument is timer

If you want to call the API every 30 seconds and warns when pokemon with IV >= 80 are found.

	php pokesniperswarner.class.php 80 30

You can't set the timer lower than 15 seconds, it's to avoid spam and too many requests on the API.


Happy pokemon spining !
