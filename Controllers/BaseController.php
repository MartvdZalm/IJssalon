<?php
namespace Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseController
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(DIR_TEMPLATES);
        $this->twig = new Environment($loader);
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

        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
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
                        $minLength = 8; // example minimum length
                        if (strlen($formData[$field]) < $minLength) {
                            $errors[$field] = ucfirst($field) . " must be at least $minLength characters long.";
                        }
                        break;
                    case 'max_length':
                        $maxLength = 255; // example maximum length
                        if (strlen($formData[$field]) > $maxLength) {
                            $errors[$field] = ucfirst($field) . " must not exceed $maxLength characters.";
                        }
                        break;
                    case 'numeric':
                        if (!is_numeric($formData[$field])) {
                            $errors[$field] = ucfirst($field) . ' must be a number.';
                        }
                        break;
                    case 'alpha':
                        if (!ctype_alpha($formData[$field])) {
                            $errors[$field] = ucfirst($field) . ' must contain only letters.';
                        }
                        break;
                    // add more rules as needed
                }
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
