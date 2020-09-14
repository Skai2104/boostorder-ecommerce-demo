<?php
require 'connect.php';

$sql = mysqli_query($con, "SELECT * FROM orders WHERE send_notification = 1 GROUP BY order_id ORDER BY updated_at DESC");

$updatedOrders = array();

if ($sql) {
    if (mysqli_num_rows($sql) > 0) {
        while ($row = mysqli_fetch_object($sql)) {
            array_push($updatedOrders, $row);
        }
    }
}

mysqli_close($con);

echo json_encode($updatedOrders);
