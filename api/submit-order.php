<?php
// If there is data posted
if (isset($_POST['data'])) {
    require 'connect.php';

    $data = json_decode($_POST['data']);

    $repeatedOrderId = true;

    // Repeat the process if the order ID is repeated
    while ($repeatedOrderId) {
        // Generate 5 digits randomly
        $orderId = rand(10000, 99999);

        // Check if the order ID is already existed in the database
        $sql = mysqli_query($con, "SELECT * FROM orders WHERE order_id = '$orderId'");

        // If there is no result (not repeated)
        if (mysqli_num_rows($sql) <= 0) {
            // Stop the looping and proceed
            $repeatedOrderId = false;
            break;
        }
    }

    foreach ($data as $item) {
        // Construct the MySQL INSERT query
        $query = "INSERT INTO orders (order_id, product_id, product_name, product_img, quantity)
                    VALUES ('$orderId', '$item->productId', '$item->productName', '$item->productImg', '$item->qty')";        

        // Execute the query
        mysqli_query($con, $query);
    }

    mysqli_close($con);

    echo "submitted";
}
