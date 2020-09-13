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
                            <i class="fas fa-trash-alt fa-lg"></i>
                        </div>
                    </div>
                </div>
            ';
        }
        ?>
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
    }
</script>

<?php
include "includes/footer.php";
?>