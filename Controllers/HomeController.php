<?php
namespace Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        $data = array(
            'styles' => $this->styles,
            'title' => 'Home',
            'headerLinks' => $this->headerLinks,
            'isLoggedIn' => isset($_SESSION['id']),
        );

        $this->render('header.twig', $data);

        $this->render('content1.twig');

        $this->render('home.twig');
        
        $this->render('content2.twig');

        $data = array(
            'scripts' => $this->scripts,
        );
        $this->render('footer.twig', $data);
    }
}
