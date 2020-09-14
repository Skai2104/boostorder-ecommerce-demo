<?php
include "includes/header.php";

// Access the orders array queried from the database via the API
require "api/get-orders.php";
?>

<h3 class="mt-4">My Orders</h3>
<hr>
<div class="row justify-content-center">
    <div class="col-10">
        <?php
        // If there is any order placed
        if (sizeof($orders) > 0) {
            $previousOrderId = "";
            $orderStatus = "";
            $i = 0;

            // Loop through the orders array
            foreach ($orders as $item) {
                // If the current order ID is not the same as the previous order ID
                if ($item->order_id !== $previousOrderId) {
                    // Avoid the tag closing at the first iteration
                    if ($i !== 0) {
                        // Closing of list group and card div
                        echo '</ul>';

                        // Only display the card footer if the order status is not returned/refunded or cancelled
                        if ($orderStatus !== 'Requested for Return/Refund' && $orderStatus !== 'Cancelled' && $orderStatus !== 'Returned' && $orderStatus !== 'Refunded') {
                            echo '<div class="card-footer text-right">
                                <button class="btn btn-danger" onclick="updateOrderStatus(\'' . $previousOrderId . '\', \'' . $orderStatus . '\')">';

                            if ($orderStatus === 'Processing') {
                                echo 'Cancel Order';
                            } else {
                                echo 'Request for Return/Refund';
                            }

                            echo '</button>
                                </div>
                            ';
                        }

                        echo '</div>';
                    }

                    echo '
                        <div class="card shadow mb-4 card-order" title="Click for details" onclick="viewOrderDetails(\'' . $item->order_id . '\')">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <p class="mb-0">Order ID: #' . $item->order_id . '</p>
                                    </div>
                                    <div class="col-4 text-right">
                                        <p class="mb-0">' . $item->status . '</p>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                    ';

                    // Set the current order ID as the previous order ID
                    $previousOrderId = $item->order_id;

                    // Set the current order status as the previous order status
                    $orderStatus = $item->status;
                }

                echo '        
                    <li class="list-group-item">
                        <div class="row text-center">
                            <div class="col-2 d-flex align-items-center">
                                <img class="img-product-cart" src="' . $item->product_img . '">
                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <h5 class="mb-0">' . $item->product_name . '</h5>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                x' . $item->quantity . '
                            </div>
                        </div>
                    </li>
                ';

                $i++;
            }

            // Only display the card footer if the order status is not returned/refunded or cancelled
            if ($orderStatus !== 'Requested for Return/Refund' && $orderStatus !== 'Cancelled' && $orderStatus !== 'Returned' && $orderStatus !== 'Refunded') {
                // Display the card footer for the last item
                echo '
                </ul>
                <div class="card-footer text-right">
                    <button class="btn btn-danger" onclick="updateOrderStatus(\'' . $previousOrderId . '\', \'' . $orderStatus . '\')">';

                if ($orderStatus === 'Processing') {
                    echo 'Cancel Order';
                } else {
                    echo 'Request for Return/Refund';
                }

                echo '</button>
                </div>
                </div>
                ';
            }
        } else {
            // Else show the message
            echo '
                <div class="card shadow text-center p-4">
                    <h5>You don\'t have any orders yet.</h5>
                    <a href="index.php" class="btn btn-primary text-white w-auto mx-auto mt-4">Home</a>
                </div>
            ';
        }
        ?>
    </div>
</div>

<script>
    function updateOrderStatus(orderId, orderStatus) {
        $.post('api/update-order-status.php', {
            orderId: orderId,
            orderStatus: orderStatus
        }, result => {
            if (result === 'success') {
                // Reload the page to reflect the changes
                location.reload();
            } else {
                // Show the error message
                alert('An error has occurred, please try again.');
            }
        });
    }

    function viewOrderDetails(orderId) {
        // Redirect to the order details page
        var url = 'orderDetails.php?orderId=' + orderId;

        location.assign(url);
    }
</script>

<?php
include "includes/footer.php";
?>