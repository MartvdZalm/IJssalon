<?php
namespace System\Common;

class Product
{
    private $id;

    private $name;

    private $price;

    private $description;

    public function __construct($id)
    {
        $this->id = $id;
    }
  
    public function getId()
    {
      return $this->id;
    }
  
    public function getName()
    {
      return $this->name;
    }
  
    public function getPrice()
    {
      return $this->price;
    }
  
    public function getDescription()
    {
      return $this->description;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
  
    public function setPrice($price)
    {
      $this->price = $price;
    }
  
    public function setDescription($description)
    {
      $this->description = $description;
    }
}