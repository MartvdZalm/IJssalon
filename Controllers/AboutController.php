<?php
namespace Controllers;

use System\Common\ProductManager;

class AboutController extends BaseController
{
    public function index()
    {
        $productManager = new ProductManager();

        $this->header('About');

        $this->content1($productManager);

        $this->render('about.twig');
        
        $this->content2($productManager);

        $this->footer();
    }
}