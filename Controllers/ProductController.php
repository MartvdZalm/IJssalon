<?php
namespace Controllers;

use System\Common\Product;
use System\Common\ProductManager;

class ProductController extends BaseController
{
    public function index($id)
    {
        $productManager = new ProductManager();
        $product = new Product($id);

        $this->header();

        $this->content1($productManager);

        $data = array(
            'product' => $product->getProduct(),
        );

        $this->render('product.twig', $data);
        
        $this->content2($productManager);

        $this->footer();
    }
}