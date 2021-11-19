<?php

namespace app;

use PDO;

class Db
{
    protected $db;

    protected $data;

    public function __construct()
    {
        $config = require 'db.php';
        $sql1 = "SELECT COUNT(*) AS total FROM products";
        $this->db = new PDO( 'mysql:host='.$config['host'].';dbname='.$config['dbname'].'', $config['user'], $config['password'] );
        $res = $this->query($sql1);
        $this->data = $res->fetch(PDO::FETCH_ASSOC);
        $this->parsXls($this->data);
    }

    public function query($sql) {
        $stmt = $this->db->prepare( $sql );
        $stmt->execute();
        return $stmt;
    }

    public function parsXls($data)
    {
        if ($data['total']<1) {
            require '../vendor/autoload.php';
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
            $reader->setReadDataOnly(TRUE);
            $spreadsheet = $reader->load('../pricelist.xls');
            $worksheet = $spreadsheet->getActiveSheet();
            $highRow = $worksheet->getHighestRow();
            $highColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highColumn);
            $lines = $highRow;
            if ($lines <= 0) {
                exit ('No data in table((');
            }
            $sql = "INSERT INTO `products` (`id`, `name`, `price`, `wholesale_price`, `warehouse_1`, `warehouse_2`, `country`, `note`) VALUES ";
            for ($row = 2; $row <= $highRow; $row++) {
                $name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $price = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $wholesale_price = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $warehouse_1 = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $warehouse_2 = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $country = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $sql .= "(NULL, '$name','$price','$wholesale_price','$warehouse_1', '$warehouse_2', '$country', '-'),";
            }
            $sql = rtrim($sql, ",");
            $this->query($sql);
        }
    }

}