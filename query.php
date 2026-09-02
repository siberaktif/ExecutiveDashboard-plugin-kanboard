<?php
$db = new PDO('sqlite:../../data/db.sqlite');
$stmt = $db->query("SELECT * FROM tasks WHERE title LIKE '%Fonlama%'");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt = $db->query("SELECT * FROM projects WHERE name LIKE '%Fonlama%'");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
