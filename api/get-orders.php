<?php
require 'connect.php';

// Get the orders from the database
$sql = mysqli_query($con, "SELECT * FROM orders ORDER BY created_at DESC");

$orders = array();

// If the query is successfully executed
if ($sql) {
    // If there is any result
    if (mysqli_num_rows($sql) > 0) {
        // Loop through the results
        while ($data = mysqli_fetch_object($sql)) {
            // Add to the orders array
            array_push($orders, $data);
        }
    }
}