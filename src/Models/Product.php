<?php

namespace App\Models;

class Product extends Model
{
	public function __construct()
	{
		$this->selectAllQuery = "SELECT * FROM products ORDER BY created_at DESC";
		$this->selectById     = "SELECT * FROM products WHERE id=(:id)";
		$this->insertRow      = "INSERT INTO products (title) VALUES (:title)";
		$this->updateRow      = "UPDATE products SET title=:title WHERE id=:id";
		$this->deleteRow      = "DELETE FROM products WHERE id=(:id)";
	}
}