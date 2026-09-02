<?php
require __DIR__.'/../../app/constants.php';
require __DIR__.'/../../app/helpers.php';
require __DIR__.'/../../vendor/autoload.php';
// Skip check_setup
class Container extends Pimple\Container {}
$container = new Container();
// Wait, initializing PicoDb directly? If the user uses MySQL, we need DB_HOSTNAME. 
// Without config.php, it's either in env vars or it uses default SQLite. But data/db.sqlite was empty.
// Where is the database?
