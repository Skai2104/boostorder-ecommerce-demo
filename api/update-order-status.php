<?php
if (isset($_POST['orderId']) && isset($_POST['orderStatus'])) {
    require 'connect.php';

    $orderId = $_POST['orderId'];
    $orderStatus = $_POST['orderStatus'];

    // Get the new status based on the type of status update request (request for return/refund or cancel)
    $newStatus = $orderStatus === "Completed" ? "Requested for Return/Refund" : "Cancelled";

    $query = "UPDATE orders SET status = '$newStatus' WHERE order_id = '$orderId'";

    // Execute the query
    $sql = mysqli_query($con, $query);

    // If the query is executed successfully
    if ($sql) {
        // Return success message
        echo "success";
    } else {
        echo "failed: " . mysqli_error($con);
    }

    mysqli_close($con);
}