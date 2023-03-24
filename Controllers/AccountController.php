<?php
namespace Controllers;

use System\Common\ProductManager;
use System\Common\User;

class AccountController extends BaseController
{
    public function index()
    {
        $productManager = new ProductManager();
        $user = new User();

        if (!isset($_SESSION['id'])) {
            $this->redirect(HTTP_SERVER.'login');
        }

        $this->header();

        $this->content1($productManager);

        $data = array(
            'user' => $user->getUser($_SESSION['id']),
        );
        $this->render('account.twig', $data);
        
        $this->content2($productManager);

        $this->footer();
    }
}