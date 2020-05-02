<?php

include_once('db.php');
class Product extends Conn{
        private $total;
        private $name;
        private $desc;
        private $price;
        private $image;

    function __construct($id){
        parent::__construct();
        $sql = "SELECT * FROM products WHERE id = $id";
        $results = mysqli_query($this->getConn(), $sql);

        $total = mysqli_query($this->getConn(), "SELECT COUNT(*) FROM products;");
        $total = mysqli_fetch_array($total, MYSQLI_ASSOC);
        $this->total = $total["COUNT(*)"];

        $product = mysqli_fetch_array($results, MYSQLI_ASSOC);
        $this->name = $product['name'];
        $this->desc = $product['desc'];
        $this->price = $product['price'];
        $this->image = $product['image'];
        $this->closeConn();
    }
    public function getTotal(){
        return $this->total;
    }
    public function getName(){
        return $this->name;
    }
    public function getDesc(){
        return $this->desc;
    }
    public function getPrice(){
        return $this->price;
    }
    public function getImg(){
        return $this->image;
    }
}
?>