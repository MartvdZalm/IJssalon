<?php
namespace System\Common;

use System\DB\Database;

class OrderManager
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new Database();
    }

    public function makeOrder($ids, $formData)
    {
        $id = $_SESSION['id'];

        $query = "INSERT INTO `order` (User, Address, City, Type, Date) 
        VALUES (:user, :address, :city, :type, :date)";
        $params = array(
            ':user' => $id, ':address' => $formData['Address'], 
            ':city' => $formData['City'], ':type' => $formData['DeliverType'],
            ':date' => $formData['Date'],
        );

        $this->pdo->query($query, $params);
        $orderId = $this->pdo->lastInsertId();
      
        $query = "INSERT INTO orderproduct (`Order`, `Product`) VALUES (:order, :product)";
        $query2 = "UPDATE product SET Quantity = Quantity - 1, Bought = Bought + 1 WHERE id=:id";
        foreach ($ids as $productId) {
            $params = array(
                ':order' => $orderId,
                ':product' => $productId['id']
            );
            $params2 = array(
                ':id' => $productId['id']
            );
            $this->pdo->query($query, $params);
            $this->pdo->query($query2, $params2);
        }
    }
    
    public function getOrders()
    {
        $query = "SELECT `order`.*, users.Username AS 'Name' FROM `order` LEFT JOIN users ON `order`.user = users.id";
        return $this->pdo->query($query);
    } 
}