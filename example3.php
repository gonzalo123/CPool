<?php
include "CPool.php";
define('NODEPHP', '127.0.0.1:1337');

$stmt = new CPoolStatement();
$stmt->setId(1);

$stmt->execute();
$data = $stmt->fetchAll();
print_r($data);