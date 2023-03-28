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

        $data = $product->getProduct();

        $this->header($data['Name']);

        $this->content1($productManager);

        $data = array(
            'product' => $data,
        );

        $this->render('product.twig', $data);
        
        $this->content2($productManager);

        $this->footer();
    }
}