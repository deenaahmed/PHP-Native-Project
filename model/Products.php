<?php

class Products extends BaseEntity
{

    public $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function searchprod($keyword)
    {
        $query = "SELECT * FROM product WHERE productname LIKE '%{$keyword}%'";
        $result = $this->conn->query($query);
        $output = array();
        //
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $output[] = new Product ($this->conn, $row['id']);
            }
        }
        return $output;
    }

    public function getProducts($prodid=false)
    {
        if($prodid)
        {
        $query = "SELECT * FROM product WHERE id=$prodid";
        $result = $this->conn->query($query);
        $output = array();
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $output[] = new Product($this->conn, $row['id']);
            }
        }
        return $output;
        }
        else
        {
        $query = "SELECT * FROM product ";
        $result = $this->conn->query($query);
        $output = array();
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $output[] = new Product($this->conn, $row['id']);
            }
        }
        return $output;
        }
    }
public function getProductsbycatid($catid)
    {
        $query = "SELECT * FROM `product` WHERE categoryid={$catid}";
        $result = $this->conn->query($query);
        $output = array();
        if($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $output[] = new Product($this->conn, $row['id']);
            }
        }
        return $output;
        
    }
}
