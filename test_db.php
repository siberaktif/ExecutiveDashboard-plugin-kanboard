<?php
require __DIR__ . '/../../app/common.php';
$container = new Pimple\Container;
$container->register(new Kanboard\ServiceProvider\DatabaseProvider);
$container->register(new Kanboard\ServiceProvider\ClassProvider);
$container->register(new Kanboard\ServiceProvider\CacheProvider);

$db = $container['db'];
$all_links = $db->table('task_has_links')
    ->join('links', 'id', 'link_id', 'task_has_links')
    ->join('tasks AS t1', 'id', 'task_id', 'task_has_links')
    ->join('tasks AS t2', 'id', 'opposite_task_id', 'task_has_links')
    ->eq('t1.is_active', 1)
    ->eq('t2.is_active', 1)
    ->columns(
        'task_has_links.task_id', 
        't1.title AS task_title', 
        't1.color_id AS task_color',
        'task_has_links.opposite_task_id', 
        't2.title AS opposite_title',
        't2.color_id AS opposite_color',
        'links.label AS link_label',
        'links.id AS link_id'
    )
    ->findAll();

print_r($all_links);
