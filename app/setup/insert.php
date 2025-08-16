<?php
$db = new PDO("mysql:host=db;dbname=kickstartblog", "docker", "password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
	$queryStr = "INSERT INTO users (name, password, email) VALUES ('admin', MD5('admin'), 'youremail@domain.com')";
	$db->query($queryStr);
	$queryStr = "INSERT INTO posts (title, content) VALUES ('Hello, World!', 'Hello!\r\nThis is my first post!');";
} catch (PDOException $e) {
	echo $e->getMessage();
}
