<?php
namespace Controllers;

use System\Common\ProductManager;

class OrderController extends BaseController
{
    public function index()
    {
        $productManager = new ProductManager();

        $this->header();

        $this->content1($productManager);

        $data = array(
            'producten' => $productManager->getProducts(),
        );
        $this->render('order.twig', $data);
        
        $this->content2($productManager);

        $this->footer();
    }
}