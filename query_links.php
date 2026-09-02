<?php
require __DIR__ . '/../../app/common.php';
$c = new \Pimple\Container();
$db = new \PicoDb\Database(array('driver' => 'sqlite', 'filename' => __DIR__ . '/../../data/db.sqlite'));
$links = $db->table('links')->findAll();
print_r($links);
?>
