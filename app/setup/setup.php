<?php
$db = new PDO("mysql:host=db;dbname=kickstartblog","docker", "password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
	$queryStr = "CREATE TABLE users (id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(40), password VARCHAR(100), email VARCHAR(150))";
	$db->query($queryStr);
	$queryStr = "CREATE TABLE posts (id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255), content TEXT)";
	$db->query($queryStr);
} catch (PDOException $e) {
	echo $e->getMessage();
}
