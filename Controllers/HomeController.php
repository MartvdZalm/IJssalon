<?php
namespace Controllers;

use System\Common\ProductManager;

class HomeController extends BaseController
{
    public function index()
    {
        $this->render('header.twig');

        $productManager = new ProductManager();

        $products = $productManager->getProducts();

        $data = array(
            'title' => 'Home',
            'products' => $products
        );

        $this->render('home.twig', $data);

        $this->render('footer.twig');
    }
}
