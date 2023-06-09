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
            'Shop' => HTTP_SERVER,
            'About Us' => HTTP_SERVER.'about',
            'Account' => HTTP_SERVER.'account',
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

    protected function getFormFileNames($formFields)
    {
        $formData = [];

        foreach ($formFields as $field) {
            $formData[$field] = basename($_FILES[$field]['name']) ?? null;
            
            $tempFile = $_FILES[$field]['tmp_name'];
            $destination = DIR_IMAGES.$formData[$field];
            move_uploaded_file($tempFile, $destination);
        }

        return $formData;
    }

    protected function getAjaxData()
    {
        // Read the raw POST data from the request body
        $rawData = file_get_contents("php://input");
    
        // Parse the data as JSON
        $jsonData = json_decode($rawData, true);
    
        // Return the data as an associative array
        return is_array($jsonData) ? $jsonData : array();
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

    protected function header($title)
    {
        $data = array(
            'styles' => $this->styles,
            'title' => $title,
            'headerLinks' => $this->headerLinks,
            'isLoggedIn' => isset($_SESSION['id']),
        );
        $this->render('header.twig', $data);
    }

    protected function adminHeader($title)
    {
        $data = array(
            'styles' => array(DIR_CSS.'admin.css') ,
            'title' => $title,
        );
        $this->render('adminHeader.twig', $data);
    }

    protected function adminFooter()
    {
        $data = array(
            'scripts' => array(DIR_JAVASCRIPT.'admin.js'),
        );
        $this->render('adminFooter.twig', $data);
    }

    protected function footer()
    {
        $data = array(
            'scripts' => $this->scripts,
        );
        $this->render('footer.twig', $data);
    }

    protected function content1($product)
    {
        $data = array(
            'product' => $product->getProductOfTheDay(),
        );
        $this->render('content1.twig', $data);
    }

    protected function content2($producten)
    {
        $data = array(
            'producten' => $producten->getBestSelling(),
        );
        $this->render('content2.twig', $data);
    }
}
