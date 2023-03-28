<?php
namespace Controllers;

use System\Common\Product;
use System\Common\ProductManager;
use System\Common\User;
use System\Common\UserManager;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $this->checkAccount();

        $this->adminHeader('Admin - Dashboard');

        $this->render('adminDashboard.twig');

        $this->adminFooter();
    }

    public function users()
    {
        $this->checkAccount();

        $userManager = new UserManager();

        $this->adminHeader('Admin - Users');

        $data = array(
            'users' => $userManager->getUsers(),
        );

        $this->render('adminUsers.twig', $data);

        $this->adminFooter();
    }

    public function user($id)
    {
        $this->checkAccount();

        $user = new User();

        $data = $user->getUser($id);

        $this->adminHeader('Admin - '. $data['Username']);

        $data = array(
            'user' => $data,
        );

        $this->render('adminUser.twig', $data);

        $this->adminFooter();
    }

    public function producten()
    {
        $this->checkAccount();

        $producten = new ProductManager();

        $this->adminHeader('Admin - Producten');

        $data = array(
            'producten' => $producten->getProducts(),
        );

        $this->render('adminProducten.twig', $data);

        $this->adminFooter();
    }

    public function product($id)
    {
        $this->checkAccount();

        $product = new Product($id);
    }

    public function orders()
    {
        $this->checkAccount();

        $this->adminHeader('Admin - Orders');

        $this->render('adminOrders.twig');

        $this->adminFooter();
    }

    private function checkAccount()
    {
        if (!$_SESSION['authenticated']) {
            $this->redirect(HTTP_SERVER);
        }
    }
}