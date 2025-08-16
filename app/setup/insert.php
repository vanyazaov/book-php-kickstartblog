<?php
$db = new PDO("mysql:host=db;dbname=kickstartblog", "docker", "password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
	$password = crypt('admin', '$2a$07$R.gJb2U2N.FmZ4hPp1y2CN$');
	$queryStr = "INSERT INTO users (name, password, email) VALUES ('admin', '$password', 'youremail@domain.com')";
	$db->query($queryStr);
	$queryStr = "INSERT INTO posts (title, content) VALUES ('Hello, World!', 'Hello!\r\nThis is my first post!');";
} catch (PDOException $e) {
	echo $e->getMessage();
}
