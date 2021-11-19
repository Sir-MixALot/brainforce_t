<?php
include_once 'Db.php';
$model = new \app\Db();
$arr = json_decode(file_get_contents('php://input'), true);
$price = lcfirst($arr['price']);
$from = $arr['from'];
$to = $arr['to'];
$warehouse = ($arr['warehouse'] == 1) ? "warehouse_1" : "warehouse_2";
$ml = ($arr['ml'] == 'More') ? ">" : "<";
$pieces = $arr['pieces'];
$sql = "SELECT * FROM products where ".$price." BETWEEN ".$from." and ".$to." and ".$warehouse." ".$ml." ".$pieces."";
$data = $model->query($sql);
$dataArr = $data->fetchAll();
echo json_encode($dataArr);