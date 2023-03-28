<?php
namespace Controllers;

use System\Common\User;

class LoginController extends BaseController
{
    public function index()
    {
        $formNames = ['email', 'password'];
        $rules = [
            'email' => 'email',
            'password' => 'min_length',
        ];

        $data = array(
            'styles' => $this->styles,
            'signUpLink' => HTTP_SERVER.'register'
        );

        if (isset($_POST['login'])) {
            $formData = $this->getFormData($formNames);
            $errors = $this->validate($formData, $rules);

            if (empty($errors)) {
                $user = new User();

                $error = $user->login($formData);
                if (empty($error)) {
                    if ($_SESSION['authenticated']) {
                        $this->redirect(HTTP_ADMIN);
                    } else {
                        $this->redirect(HTTP_SERVER);
                    }
                }

                $errors['extraError'] = $error;
            }

            $data['errors'] = $errors;
        }

        $this->render('login.twig', $data);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        $this->redirect(HTTP_SERVER.'login');
    }
}