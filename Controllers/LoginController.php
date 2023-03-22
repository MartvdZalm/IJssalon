<?php
namespace Controllers;

class LoginController extends BaseController
{
    public function index()
    {
        $styles = array(
            DIR_STYLESHEETS.'stylesheet.css', 
            DIR_STYLESHEETS.'stylesheet.scss'
        );

        $data = array(
            'styles' => $styles
        );

        $this->render('login.twig', $data);
    }
}