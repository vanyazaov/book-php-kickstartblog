<?php
$db = new PDO("mysql:host=db;dbname=kickstartblog","docker", "password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
	$queryStr = "CREATE TABLE users (id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(40), password VARCHAR(100), email VARCHAR(150))";
	$db->query($queryStr);
	$queryStr = "CREATE TABLE posts (id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255), content TEXT)";
	$db->query($queryStr);
	$queryStr = "CREATE TABLE comments (id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, postid INTEGER(11) NOT NULL, email VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, comment LONGTEXT NOT NULL, FOREIGN KEY (postid) REFERENCES posts (id))";
	$db->query($queryStr);
} catch (PDOException $e) {
	echo $e->getMessage();
}
