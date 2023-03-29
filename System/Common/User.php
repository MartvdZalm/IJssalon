<?php
namespace System\Common;

use System\DB\Database;

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new Database();
    }

    public function getUser($id)
    {
        $query = "SELECT * FROM users WHERE id=:id";
        $params = array(':id' => $id);
        return $this->pdo->queryOneRow($query, $params);
    }

    public function updateAccount($formData)
    {
        $query = "UPDATE users SET Username=?, Email=?, Address=?, ZipCode=?, City=?, PhoneNumber=? WHERE Password=?";
        $params = array(
            $formData['name'], $formData['email'], $formData['address'], $formData['zipcode'], 
            $formData['city'], $formData['phonenumber'], md5($formData['password']),
        );
        $this->pdo->query($query, $params);
    }

    public function deleteAccount($formData)
    {
        $query = "DELETE FROM users WHERE id=? AND password=?";
        $params = array($_SESSION['id'], md5($formData['password']));
        $this->pdo->query($query, $params);
    }
}