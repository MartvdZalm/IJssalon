<?php
namespace Controllers;

use System\Common\Order;
use System\Common\OrderManager;
use System\Common\ProductManager;
use System\Common\User;

class AccountController extends BaseController
{
    public function index()
    {
        $formNames = [
            'name', 'email', 'address', 'zipcode', 'city', 'phonenumber', 'password',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'email',
            'password' => 'required',
        ];

        $productManager = new ProductManager();
        $user = new User();
        $orderManager = new OrderManager();

        if (!isset($_SESSION['id'])) {
            $this->redirect(HTTP_SERVER.'login');
        }

        if (isset($_POST['change'])) {
            $formData = $this->getFormData($formNames);
            $errors = $this->validate($formData, $rules);

            if (empty($errors)) {
                $user->updateAccount($formData);   
            }        
        }

        if (isset($_POST['deleteAccount'])) {
            $formData = $this->getFormData($formNames);
            $errors = $this->validate($formData, $rules);

            if (empty($errors)) {
                $user->deleteAccount($formData);
                $this->redirect(HTTP_SERVER.'logout');
            }
        }

        $this->header('Account');

        $this->content1($productManager);

        $data = array(
            'user' => $user->getUser($_SESSION['id']),
            'orders' => $orderManager->getOrdersId($_SESSION['id']),
        );
        $this->render('account.twig', $data);
        
        $this->content2($productManager);

        $this->footer();
    }

    public function order($id)
    {
        $productManager = new ProductManager();
        $order = new Order($id);

        $this->header('Order');

        $this->content1($productManager);

        $data = array(
            'order' => $order->getOrder(),
            'producten' => $order->getProducts(),
        );
        $this->render('order.twig', $data);
        
        $this->content2($productManager);

        $this->footer();
    }
}