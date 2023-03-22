<?php
namespace Controllers;

use System\Common\ProductManager;

class HomeController extends BaseController
{
    public function index()
    {
        $productManager = new ProductManager();

        $products = $productManager->getProducts();


        $data = array(
            'title' => 'Home',
        );

        $this->render('header.twig', $data);


        $data = array(
            'products' => $products
        );

        $this->render('home.twig', $data);
        

        $this->render('footer.twig');
    }
}
