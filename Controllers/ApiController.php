<?php
namespace Controllers;

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
                array_push($ids, $item['id']);
        
                // Increment quantity for this product ID
                if (isset($quantities[$item['id']])) {
                    $quantities[$item['id']]++;
                } else {
                    $quantities[$item['id']] = 1;
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
}