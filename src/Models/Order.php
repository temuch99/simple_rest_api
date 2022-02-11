<?php

namespace App\Models;

class Order extends Model
{
    public function __construct()
    {
        $this->selectAllQuery = "SELECT o.id as id, o.name as name, o.phone as phone, p.title as product_title FROM orders o LEFT JOIN products p ON o.product_id=p.id ORDER BY o.created_at DESC";
        $this->selectById     = "SELECT o.id as id, o.name as name, o.phone as phone, o.created_at as created_at, p.title as product_title, p.id as product_id FROM orders o LEFT JOIN products p ON o.product_id=p.id WHERE o.id=:id";
        $this->insertRow      = "INSERT INTO orders (name, phone, product_id) VALUES (:name, :phone, :product_id)";
        $this->updateRow      = "UPDATE orders SET name=:name, phone=:phone, product_id=:product_id WHERE id=:id";
        $this->deleteRow      = "DELETE FROM orders WHERE id=:id";
    }
}
