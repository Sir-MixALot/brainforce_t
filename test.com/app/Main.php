<?php

namespace app;
use PDO;
include 'Model.php';

class Main extends Model
{

    public function getData()
    {
        $sql = "SELECT * FROM products";
        return $this->db->query($sql);
    }

    public function changeNote()
    {
            $sql = "UPDATE products SET note  = 'Осталось мало!! Срочно докупите!!!' WHERE warehouse_1 < 20 or warehouse_2 < 20";
            $this->db->query($sql);
    }

    public function getWarehouse($val)
    {
        $sql = "SELECT SUM(".$val.") AS total FROM products";
        $res = $this->db->query($sql);
        $total = $res->fetch(PDO::FETCH_ASSOC);
        return $total['total'];
    }


    public function getAvgPrice($val)
    {
        $sql = "SELECT AVG(".$val.") AS total FROM products";
        $res = $this->db->query($sql);
        $total = $res->fetch(PDO::FETCH_ASSOC);
        return $total['total'];
    }

    public function getMinMax($val)
    {
        $sql = "SELECT ".$val." AS total FROM products";
        $res = $this->db->query($sql);
        $total = $res->fetch(PDO::FETCH_ASSOC);
        return $total['total'];
    }

}