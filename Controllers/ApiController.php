<?php
namespace Controllers;

use System\Common\OrderManager;
use System\DB\Database;

class ApiController extends BaseController
{
    public function cart()
    {
        $pdo = new Database();
        $ids = array();
        $quantities = array(); // Initialize array to keep track of product quantities
        $producten = $this->getAjaxData();
        
        if (count($producten) != 0) {
            foreach ($producten as $item) {
                if (isset($item['id'])) {
                    array_push($ids, $item['id']);
        
                    // Increment quantity for this product ID
                    if (isset($quantities[$item['id']])) {
                        $quantities[$item['id']]++;
                    } else {
                        $quantities[$item['id']] = 1;
                    }
                }
            }
        
            $idString = implode(',', $ids);
            $query = "SELECT * FROM product WHERE id IN ($idString)";
        
            $producten = $pdo->query($query);
        }
        
        $data = array(
            'producten' => $producten,
            'quantities' => $quantities // Add quantities array to data
        );
        

        $this->render('cartProduct.twig', $data);
    }

    public function makeOrder()
    {
        $formNames = [
            'Address','City', 
            'Date','DeliverType',
            'cart', 
        ];

        $rules = [
            'Address' => 'required',
            'City' => 'required',
            'Date' => 'required',
            'DeliverType' => 'required',  
        ];

        $formData = $this->getFormData($formNames);

        $cart = json_decode($formData['cart'], true);
        
        if (count($cart) != 0) {
            $errors = $this->validate($formData, $rules);
            
            if (empty($errors)) {
                $order = new OrderManager();
                $order->makeOrder($cart, $formData);
            } else {
                foreach ($errors as $error) {
                    echo $error;
                }
            }
        }
    }

    public function removeUser()
    {
        $pdo = new Database();
        $data = $this->getFormData(array('id'));
        
        $query = "DELETE FROM users WHERE id=?";
        $params = array($data['id']);
        $pdo->query($query, $params);
    }
}