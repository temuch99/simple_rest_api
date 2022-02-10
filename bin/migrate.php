<?php

print("Connecting to database\n");

$env = json_decode(file_get_contents(".env"), true);
$dbh = new PDO(
	"mysql:dbname=" . $env["DATABASE"] . ";host=" . $env["HOST"],
	$env["USER"], 
	$env["PASSWORD"]
);

print("Create products table\n");

$dbh->exec("CREATE TABLE products (id INTEGER PRIMARY KEY AUTO_INCREMENT, title VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL DEFAULT NOW())");

print("Create orders table\n");

$dbh->exec("CREATE TABLE orders (id INTEGER PRIMARY KEY AUTO_INCREMENT, name VARCHAR(20) NOT NULL, phone VARCHAR(12) NOT NULL, created_at DATETIME NOT NULL DEFAULT NOW(), product_id INTEGER NOT NULL, FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE)");

print("Tables created\n");