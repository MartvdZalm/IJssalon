<?php
require_once('BaseController.php');

class HomeController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'Welcome to My Website!',
            'content' => 'This is the homepage of my website.'
        );

        $this->render('home.twig', $data);
    }
}
