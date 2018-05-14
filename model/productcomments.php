<?php

class productcomments extends BaseEntity {

    public $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getCommentss($prodid) {
        $query = "SELECT * FROM `ratecomment` WHERE productid={$prodid} ";
        $result = $this->conn->query($query);
        $output = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $output[] = new productcomment($this->conn, $row);
            }
        }
        return $output;
    }

}
