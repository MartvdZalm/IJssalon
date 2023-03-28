<?php
namespace System\Common;

use System\DB\Database;

class Order
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
        foreach ($ids as $productId) {
            $params = array(
                ':order' => $orderId,
                ':product' => $productId['id']
            );
            $this->pdo->query($query, $params);
        }
    }
    
}