<?php
include "CPool.php";
define('NODEPHP', '127.0.0.1:1337');

$dbh = new CPool();
$sql = "SELECT * FROM USERS";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();
$stmt->closeCursor();
print_r($data);

