<?php
namespace Controllers;

use System\Common\ProductManager;

class CartController extends BaseController
{
    public function index()
    {
        $productManager = new ProductManager();

        $this->header();

        $this->content1($productManager);

        $this->render('cart.twig');
        
        $this->content2($productManager);

        $this->footer();
    }
}   