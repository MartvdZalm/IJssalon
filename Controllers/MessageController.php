<?php
namespace Controllers;

use System\Common\ProductManager;

class MessageController extends BaseController
{
    public function order()
    {
        $productManager = new ProductManager();

        $title = 'Dear valued customer';
        $text = '
            You have successfully placed an order.
            You will soon get an email with further detail about your order.
        ';

        $this->header('Message');

        $this->content1($productManager);

        $data = array(
            'title' => $title,
            'text' => $text
        );
        $this->render('message.twig', $data);
        
        $this->content2($productManager);

        $this->footer();
    }

    public function account()
    {
        $productManager = new ProductManager();

        $title = 'Dear valued customer';
        $text = '
        We kindly request that you create an account in order to place your order with us. 
        By doing so, we can offer you a more personalized and efficient experience while using our website. 
        Thank you for considering this and we look forward to serving you soon.
        ';

        $this->header('Message');

        $this->content1($productManager);

        $data = array(
            'title' => $title,
            'text' => $text
        );
        $this->render('message.twig', $data);
        
        $this->content2($productManager);

        $this->footer(); 
    }

    public function error404()
    {
        $productManager = new ProductManager();

        $title = 'Page Not Found';
        $text = "
            Oops, it looks like you've stumbled upon a page that doesn' exist! Don't worry, it's not your fault. Sometimes, links go missing or pages get moved around.
            We apologize for any inconvenience this may have caused. Use the navigation bar above to explore other parts of our site
        ";

        $this->header('Message');

        $this->content1($productManager);

        $data = array(
            'title' => $title,
            'text' => $text
        );
        $this->render('message.twig', $data);
        
        $this->content2($productManager);

        $this->footer(); 
    }
}