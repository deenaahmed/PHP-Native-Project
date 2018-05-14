<?php

class Users extends BaseEntity {

    public $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getuserss() {
        $query = "SELECT * FROM `user` ";
        $result = $this->conn->query($query);
        $output = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $output[] = new User($this->conn, $row['id']);
            }
        }
        return $output;
    }

}
