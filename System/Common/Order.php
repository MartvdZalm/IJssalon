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
        $query = "INSERT INTO `order` (Name, Address, ZipCode, City, PhoneNumber, Type, Date) 
        VALUES (:name, :address, :zipcode, :city, :phonenumber, :type, :date)";
        $params = array(
            ':name' => $formData['Name'], ':address' => $formData['Address'],
            ':zipcode' => $formData['ZipCode'], ':city' => $formData['City'],
            ':phonenumber' => $formData['PhoneNumber'], ':type' => $formData['DeliverType'],
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