<?php

$conn;

class Product extends BaseEntity {

    public $id;
    public $productname;
    public $description;
    public $photo;
    public $categoryid;
    public $price;
    public $conn;
    public $key;

    public function __construct($conn, $productId = false) {
        $this->conn = $conn;
        if ($productId) {
            $query = "SELECT * FROM product WHERE id={$productId}";
            $result = $this->conn->query($query);
            if ($result->num_rows > 0) {
                // output data of each row
                $row = $result->fetch_assoc();
                foreach ($row as $key => $value) {
                    $this->$key = $value;
                }
            } else {
                die('Product Not Found');
            }
        }
    }

    public function save() {
        $query = "INSERT INTO `product` (`id`, `description`, `photo`, `categoryid`, `productname`,`price`) VALUES (NULL, '{$this->getDescription()}', '{$this->getPhoto()}', '{$this->getCategoryid()}', '{$this->getProductname()}', '{$this->getPrice()}')";

        mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
        $this->id = mysqli_insert_id($this->conn);
        return $this->id;
    }

    public function update() {
        $query = "UPDATE `product` SET `price` = '{$this->getPrice()}',`photo` = '{$this->getPhoto()}',`productname` = '{$this->getProductname()}',`description` = '{$this->getDescription()}',`categoryid` = '{$this->getCategoryid()}'  WHERE `id` = {$this->id}";
        mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
    }

    public function delete() {
        $query = "DELETE FROM `product` WHERE `id` = '{$this->id}';";
        mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
    }

}
