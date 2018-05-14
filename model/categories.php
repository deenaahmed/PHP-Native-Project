<?php

class categories extends BaseEntity {

    public $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getcategories() {
        $query = "SELECT * FROM category ";
        $result = $this->conn->query($query);
        $output = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $output[] = new category($this->conn, $row['id']);
            }
        }
        return $output;
    }

}
