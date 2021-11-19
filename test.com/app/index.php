<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'Main.php';
use app\Main;
$main = new Main();
$dashboardData = $main->getData();
$main->changeNote();
$firstW = $main->getWarehouse('warehouse_1');
$secW = $main->getWarehouse('warehouse_2');
$price = $main->getAvgPrice('price');
$wPrice = $main->getAvgPrice('wholesale_price');
$max = $main->getMinMax('MAX(price)');
$min = $main->getMinMax('MIN(wholesale_price)');
?>


<head>
    <title>fetch</title>

</head>

<form id="filters" role="form" style="text-align: center">
    <label>Show products with: </label>
    <select id="price" required>
        <option>Price</option>
        <option>Wholesale_price</option>
    </select>
    <label>from</label>
    <input type="number" min="1" max="1000000" step="0.01" id="first" required>
    <label>to</label>
    <input type="number" min="1" max="1000000" step="0.01" id="sec"required>
    <label>rubles. On warehouse № </label>
    <select id="warehouse" required>
        <option>1</option>
        <option>2</option>
    </select>
    <select id="MoreLess" required>
        <option>More</option>
        <option>Less</option>
    </select>
    <input type="number" min="0" max="100000" step="1" id="count" required>
    <label>pieces.</label>
    <input type="submit" value="Show">
</form>

<table id="table" style="width: 100%; text-align: center">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Price</th>
        <th>Wholesale Price</th>
        <th>Warehouse#1</th>
        <th>Warehouse#2</th>
        <th>Country</th>
        <th>Note</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($dashboardData as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td <?php if($row['price'] == $max){echo 'bgcolor="red"';}?> ><?= $row['price'] ?></td>
            <td <?php if($row['wholesale_price'] == $min){echo 'bgcolor="green"';}?> ><?= $row['wholesale_price'] ?></td>
            <td><?= $row['warehouse_1'] ?></td>
            <td><?= $row['warehouse_2'] ?></td>
            <td><?= $row['country'] ?></td>
            <td><?= $row['note'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<p style="font-weight: bold">Total amount on the first warehouse:
    <?php echo $firstW; ?>
</p>
<p style="font-weight: bold">Total amount on the second warehouse:
    <?php echo $secW; ?>
</p>
<p style="font-weight: bold">Total amount of both warehouses :
    <?php echo $firstW + $secW; ?>
</p>
<p style="font-weight: bold">Average price :
    <?php echo round($price, 2); ?>
</p>
<p style="font-weight: bold">Average wholesale price :
    <?php echo round($wPrice, 2); ?>
</p>

<script src="fetch.js"></script>