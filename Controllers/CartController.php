<?php
namespace Controllers;

use System\Common\ProductManager;
use System\Common\User;

class CartController extends BaseController
{
    public function index()
    {
        $productManager = new ProductManager();  
        $user = new User();  

        $this->header();

        $this->content1($productManager);

        if (isset($_SESSION['id'])) {
            $data = array(
                'user' => $user->getUser($_SESSION['id']),
            );
            $this->render('cart.twig', $data);
        } else {
            $this->render('cart.twig');
        }
        
        $this->content2($productManager);

        $this->footer();
    }
}   