<?php
namespace Controllers;

use System\Common\ProductManager;

class SuccesController extends BaseController
{
    public function order()
    {
        $productManager = new ProductManager();

        $title = 'Order';
        $text = '
            You have successfully placed an order.
            You will soon get an email with further detail about your order.
        ';

        $this->header();

        $this->content1($productManager);

        $data = array(
            'title' => $title,
            'text' => $text
        );
        $this->render('success.twig', $data);
        
        $this->content2($productManager);

        $this->footer();
    }
}