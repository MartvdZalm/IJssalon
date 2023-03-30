<?php
namespace Controllers;

use System\Common\Brands;
use System\Common\Order;
use System\Common\OrderManager;
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

        $formNames = [
            'name', 'description', 'price', 'quantity', 'brand', 'flavourOfTheDay',
        ];

        $product = new Product($id);
        $brands = new Brands();

        if (isset($_POST['product'])) {
            $formData = $this->getFormData($formNames);
            $images = $this->getFormFileNames(array('image'));
            $product->changeValues($formData, $images);
            $this->redirect(HTTP_ADMIN.'producten');
        }

        if (isset($_POST['delete'])) {
            $product->deleteProduct($id);
            $this->redirect(HTTP_ADMIN.'producten');
        }

        $productData = $product->getProduct();
        $brandData = $brands->getBrands();

        $this->adminHeader('Admin - '. $productData['Name']);

        $data = array(
            'product' => $productData,
            'brands' => $brandData,
        );

        $this->render('adminProduct.twig', $data);

        $this->adminFooter();
    }

    public function productAdd()
    {
        $this->checkAccount();

        $formNames = [
            'name', 'description', 'price', 'quantity', 'brand', 'flavourOfTheDay',
        ];

        $productManager = new ProductManager();
        $brands = new Brands();

        if (isset($_POST['product'])) {
            $formData = $this->getFormData($formNames);
            $images = $this->getFormFileNames(array('image'));
            $productManager->addProduct($formData, $images);
            $this->redirect(HTTP_ADMIN.'producten');
        }

        $this->adminHeader('Admin - Add Product');

        $data = array('brands' => $brands->getBrands());

        $this->render('adminProductAdd.twig', $data);

        $this->adminFooter();
    }

    public function orders()
    {
        $this->checkAccount();

        $orders = new OrderManager();

        $this->adminHeader('Admin - Orders');

        $this->render('adminOrders.twig', array('orders' => $orders->getOrders()));

        $this->adminFooter();
    }

    public function order($id)
    {
        $this->checkAccount();

        $order = new Order($id);

        if (isset($_POST['accept'])) {
            $order->accept();
        }

        if (isset($_POST['cancel'])) {
            $order->cancel();
        }

        $orderData = $order->getOrder();
        $producten = $order->getProducts();

        $this->adminHeader('Admin - Order');

        $data = array(
            'order' => $orderData,
            'producten' => $producten,
        );

        $this->render('adminOrder.twig', $data);

        $this->adminFooter();
    }

    private function checkAccount()
    {
        if (!$_SESSION['authenticated']) {
            $this->redirect(HTTP_SERVER);
        }
    }
}