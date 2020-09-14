<?php
require 'connect.php';

$query = "UPDATE orders SET send_notification = 0 WHERE order_id = '$orderId'";

mysqli_query($con, $query);

mysqli_close($con);