<?php

$conn;

class category extends BaseEntity {

    public $id;
    public $categoryname;
    public $conn;

    public function __construct($conn, $categoryid = false) {


        $this->conn = $conn;
        if ($categoryid) {
            $query = "SELECT * FROM category WHERE id={$categoryid}";
            $result = $this->conn->query($query);
            if ($result->num_rows > 0) {
                // output data of each row
                $row = $result->fetch_assoc();
                foreach ($row as $key => $value) {
                    $this->$key = $value;
                }
            } else {
                die('Category Not Found');
            }
        } else {
            
        }
    }

    public function save() {
        $query = "INSERT INTO `category` (`id`, `categoryname`) VALUES (NULL, '{$this->getCategoryname()}')";

        mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
        $this->id = mysqli_insert_id($this->conn);
        return $this->id;
    }

}
