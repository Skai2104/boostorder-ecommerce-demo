<?php
include "includes/header.php";

// If there is orderId in the URL
if (isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];

    // get-order-details.php can access the order ID
    require "api/get-order-details.php";

    // Remove the notification
    require "api/update-notification.php";

} else {
    // Else redirect to the homepage
    echo "<script>location.assign('index.php')</script>";
}
?>

<h3 class="mt-4">Orders Details</h3>
<hr>
<p class="text-muted mb-0">Order ID: #<?= $orderId ?></p>
<p class="text-muted mb-2">Placed on <?= $orders[0]->created_at ?></p>
<p class="text-center">Total <?= sizeof($orders) ?> item(s)</p>
<div class="row justify-content-center">
    <div class="col-10">
        <div class="card shadow">
            <div class="card-header">
                <p class="text-right mb-0">Status: <b><?= $orders[0]->status ?></b></p>
            </div>
            <div class="card-body">
                <?php
                foreach ($orders as $item) {
                    echo '
                        <div class="row">
                            <div class="col-2 d-flex align-items-center">
                                <img class="img-product-cart" src="' . $item->product_img . '">
                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <h5 class="mb-0">' . $item->product_name . '</h5>
                            </div>
                            <div class="col-2 d-flex align-items-center">
                                Qty: <b class="ml-1">' . $item->quantity . '</b>
                            </div>
                        </div>
                        <hr>
                    ';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="text-center mt-4">
    <a class="btn btn-primary text-white w-auto" href="orders.php">Back</a>
</div>

<?php
include "includes/footer.php";
?>