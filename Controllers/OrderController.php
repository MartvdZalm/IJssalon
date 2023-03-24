<?php
namespace Controllers;

class OrderController extends BaseController
{
    public function index()
    {
        $data = array(
            'styles' => $this->styles,
            'title' => 'Order',
            'headerLinks' => $this->headerLinks,
            'isLoggedIn' => isset($_SESSION['id']),
        );

        $this->render('header.twig', $data);

        $this->render('content1.twig');

        $this->render('order.twig');
        
        $this->render('content2.twig');

        $data = array(
            'scripts' => $this->scripts,
        );
        $this->render('footer.twig', $data);
    }
}