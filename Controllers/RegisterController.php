<?php
namespace Controllers;

use System\Common\UserManager;

class RegisterController extends BaseController
{
    public function index()
    {
        $formNames = ['username', 'email', 'password', 'confirmPassword'];
        $rules = [
            'username' => 'required',
            'email' => 'email',
            'password' => 'min_length',
            'confirmPassword' => 'min_length'
        ];
    
        $data = array(
            'styles' => $this->styles,
            'signInLink' => HTTP_SERVER.'login',
        );
    
        if (isset($_POST['register'])) {
            $formData = $this->getFormData($formNames);
            $errors = $this->validate($formData, $rules);

            if (empty($errors)) {
                $user = new UserManager();

                $error = $user->register($formData);
                if (empty($error)) {
                    $this->redirect(HTTP_SERVER.'login');
                }

                $errors['extraError'] = $error;
            }

            $data['errors'] = $errors;
        }
    
        $this->render('register.twig', $data);
    }
}