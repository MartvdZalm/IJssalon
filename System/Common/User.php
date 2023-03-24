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
        return;
    }
}