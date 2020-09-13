<?php
include "includes/header.php";

// Get the cart data from the cookie
$cart = $_COOKIE['cart'];

// Convert the cart data from JSON string to array
$cart = json_decode($cart);
?>

<h3 class="mt-4">My Cart</h3>
<hr>
<div class="row justify-content-center">
    <div class="col-10">
        <?php
        // If there is items in the cart
        if (sizeof($cart) > 0) {
            foreach ($cart as $item) {
                echo '
                    <div class="card px-5 py-3 mb-3 shadow">
                        <div class="row text-center">
                            <div class="col-2 d-flex align-items-center">
                                <img class="img-product-cart" src="' . $item->productImg . '">
                            </div>
                            <div class="col-5 d-flex align-items-center">
                                <h5>' . $item->productName . '</h5>
                            </div>
                            <div class="col-4 d-flex align-items-center">
                                <div class="input-group w-50 mx-auto">                            
                                    <div class="input-group-prepend">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon1" onclick="updateQty(\'' . $item->productId . '\', false)">-</button>
                                    </div>
                                    <input id="input-' . $item->productId . '" type="text" class="form-control text-center" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" value="' . $item->qty . '">
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon1" onclick="updateQty(\'' . $item->productId . '\', true)">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1 d-flex align-items-center">
                                <button class="btn text-danger" onclick="triggerDeletionModal(\'' . $item->productId . '\', \'' . $item->productName . '\')">
                                    <i class="fas fa-trash-alt fa-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                ';
            }
        } else {
            // Else show the message
            echo '
                <div class="card shadow text-center p-4">
                    <h5>Your cart is empty.</h5>
                    <a href="index.php" class="btn btn-primary text-white w-auto mx-auto mt-4">Home</a>
                </div>
            ';
        }
        ?>
    </div>
</div>
<div class="row justify-content-center mt-4">
    <div class="col-auto">
        <button class="btn btn-primary" onclick="submitOrder()">Submit Order</button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteCartItemModal" tabindex="-1" aria-labelledby="deleteCartItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Remove item from the cart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <b id="deleteItemName"></b> will be removed from the cart, are you sure?
                <!-- Hidden input to store the product ID to be deleted -->
                <input id="deleteProductIdInput" type="hidden">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="deleteCartItem()">Remove</button>
            </div>
        </div>
    </div>
</div>

<script>
    function updateQty(productId, increment) {
        var inputId = 'input-' + productId;

        // Get the target input by using its ID
        var targetInput = document.getElementById(inputId);

        // Get the current value of the target input
        var value = targetInput.value;

        // Increase or decrease the quantity based on the button (+ or -) clicked
        increment ? value++ : value--;

        // If the value is greater than 0
        if (value > 0) {
            // Update the value of the input
            targetInput.value = value;

            updateCartItemQty(productId, value);
        }
    }

    function updateCartItemQty(productId, qty) {
        // Loop through the cart array
        cart.forEach(element => {
            // If the current product ID in the cart array is equal to the target product ID
            if (element.productId === productId) {
                // Update the quantity of the current item
                element.qty = qty;
            }
        });

        // Update the cart amount
        updateCartAmount();

        // Convert the cart into JSON string and update the cookie
        document.cookie = 'cart=' + JSON.stringify(cart);
    }

    function triggerDeletionModal(productId, productName) {
        // Trigger the deletion modal
        $('#deleteCartItemModal').modal();

        // Set the product name to the delete confirmation modal
        document.getElementById('deleteItemName').innerHTML = productName;

        // Set the product ID to the hidden input
        document.getElementById('deleteProductIdInput').value = productId;
    }

    function deleteCartItem() {
        // Get the product ID to the deleted from the hidden input
        var productId = document.getElementById('deleteProductIdInput').value;

        // Loop through the cart array
        cart.forEach((element, index) => {
            // If the current product ID in the cart array is equal to the target product ID
            if (element.productId === productId) {
                // Remove the current item from the cart array
                cart.splice(index, 1);
            }
        });

        // Update the cart amount
        updateCartAmount();

        // Convert the cart into JSON string and update the cookie
        document.cookie = 'cart=' + JSON.stringify(cart);

        // Refresh the page to reflect the changes
        location.reload();
    }

    function submitOrder() {
        $.post('api/submit-order.php', {
            data: JSON.stringify(cart)
        }, result => {
            if (result === 'success') {
                // Navigate to the orders page
            }
        });
    }
</script>

<?php
include "includes/footer.php";
?>