<?php

$conn;

class User extends BaseEntity {

    public $id;
    public $username;
    public $password;
    public $phone;
    public $photo;
    public $email;
    public $conn;

    public function __construct($conn, $userId = false) {
        $this->conn = $conn;
        if ($userId) {
            $query = "SELECT * FROM `user` WHERE id={$userId}";
            $result = $this->conn->query($query);
            if ($result->num_rows > 0) {
                // output data of each row
                $row = $result->fetch_assoc();
                foreach ($row as $key => $value) {
                    $this->$key = $value;
                }
            } else {
                die('User Not Found');
            }
        }
    }

    public function save() {
        $query = "INSERT INTO `user` (`id`, `username`, `password`, `photo`, `email`, `phone`) "
                . "VALUES (NULL, '{$this->getUsername()}', '{$this->getPassword()}', '{$this->getPhoto()}', '{$this->getEmail()}', '{$this->getPhone()}');";

        mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
        $this->id = mysqli_insert_id($this->conn);
        return $this->id;
    }

    public function update() {
        $query = "UPDATE `user` SET `phone` = '{$this->getPhone()}',`photo` = '{$this->getPhoto()}',`username` = '{$this->getUsername()}',`email` = '{$this->getEmail()}'  WHERE `id` = {$this->id}";
        mysqli_query($this->conn, $query) or die(mysqli_error($this->conn));
    }

}
