<?php

$conn;

class productcomment extends BaseEntity {

    public $id;
    public $productid;
    public $comment;
    public $rate;
    public $userid;
    public $createdat;

    public function __construct($conn, $productArray = false) {
        $this->conn = $conn;
        if ($productArray) {
            $this->id = $productArray['id'];
            $this->productid = $productArray['productid'];
            $this->comment = $productArray['comment'];
            $this->rate = $productArray['rate'];
            $this->userid = $productArray['userid'];
            $this->createdat = $productArray['createdat'];
        }
    }

    public function save() {
        $query = "INSERT INTO `ratecomment` (`id`, `productid`, `comment`, `rate`, `userid`, `createdat`) VALUES (NULL, '{$this->getProductid()}', '{$this->getComment()}','{$this->getRate()}','{$this->getUserid()}',NOW());";
        mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
        $this->id = mysqli_insert_id($this->conn);
        return $this->id;
    }

    public function getcreatedatbycmmentid($ids) {
        $query = "SELECT * FROM `ratecomment` WHERE id = {$ids};";
        $result = $this->conn->query($query);
        $output = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $output1 = new productcomment($this->conn, $row);
                $output = $output1->getCreatedat();
            }
        }

        return $output;
    }

}
