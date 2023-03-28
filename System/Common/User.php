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

    public function register($data)
    {

        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];
        $confirmPassword = $data['confirmPassword'];
    
        if ($password == $confirmPassword) {
    
            $query = "SELECT * FROM users WHERE Username = :username OR Email = :email LIMIT 1";
            $params = array(':username' => $username, ':email' => $email);
            $existingUser = $this->pdo->query($query, $params);
    
            if (!empty($existingUser)) {
                return "User already exists";
            } 
    
            $query = "INSERT INTO users (Username, Email, Password) VALUES(:username, :email, :password)";
            $params = array(':username' => $username, ':email' => $email, ':password' => md5($password));
            $this->pdo->query($query, $params);
    
            return;
        } 

        return "Passwords do not match";
    }   

    public function login($data)
    {
        $email = $data['email'];
        $password = $data['password'];
    
        $query = "SELECT * FROM users WHERE Email = :email AND Password = :password LIMIT 1";
        $params = array(':email' => $email, ':password' => md5($password));
        $user = $this->pdo->queryOneRow($query, $params);

        if (empty($user)) {
            return "Incorrect password or email";
        } 

        $_SESSION['id'] = $user['id'];
        if ($user['IsAdmin']) {
            $_SESSION['authenticated'] = true;
        } else {
            $_SESSION['authenticated'] = false;
        }
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