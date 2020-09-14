<?php

require 'connect.php';

$query = "SELECT * FROM orders WHERE order_id = '$orderId'";

$sql = mysqli_query($con, $query);

$orders = array();

if ($sql) {
    if (mysqli_num_rows($sql) > 0) {
        while ($row = mysqli_fetch_object($sql)) {
            array_push($orders, $row);
        }
    }
}

mysqli_close($con);