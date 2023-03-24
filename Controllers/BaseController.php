<?php
namespace Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseController
{
    protected $twig;
    protected $headerLinks;
    protected $styles;
    protected $scripts;

    public function __construct()
    {
        $loader = new FilesystemLoader(DIR_TEMPLATES);
        $this->twig = new Environment($loader);

        $this->styles = array(DIR_CSS.'stylesheet.css');
        $this->scripts = array(DIR_JAVASCRIPT.'script.js');

        if (isset($_SESSION['id'])) {
            $linkname = 'logout';
        } else {
            $linkname = 'login';
        }

        $this->headerLinks = array(
            'Home' => HTTP_SERVER,
            'Order' => HTTP_SERVER.'order',
            'Blog' => HTTP_SERVER.'blog',
            'About Us' => HTTP_SERVER.'aboutus',
            'Cart' => HTTP_SERVER.'cart',
            $linkname => HTTP_SERVER.$linkname,
        );
    }
    
    protected function render($template, $data = [])
    {
        echo $this->twig->render($template, $data);
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit();
    }

    protected function getFormData($formFields)
    {
        $formData = [];

        foreach ($formFields as $field) {
            $formData[$field] = $_POST[$field] ?? null;
        }

        return $formData;
    }

    protected function validate($formData, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            switch ($rule) {
                case 'required':
                    if (empty($formData[$field])) {
                        $errors[$field] = ucfirst($field) . ' is required.';
                    }
                break;
                case 'email':
                    if (!filter_var($formData[$field], FILTER_VALIDATE_EMAIL)) {
                        $errors[$field] = ucfirst($field) . ' must be a valid email address.';
                    }
                break;
                case 'min_length':
                    $minLength = 7; 
                    if (strlen($formData[$field]) < $minLength) {
                        $errors[$field] = "Must be at least $minLength characters long.";
                    }
                break;
            }
        }
        return $errors;
    }

    protected function sanitize($formData)
    {
        foreach ($formData as $key => $value) {
            $formData[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }

        return $formData;
    }
}
