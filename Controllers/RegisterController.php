<?php
namespace Controllers;

class RegisterController extends BaseController
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

        $this->render('register.twig', $data);
    }
}