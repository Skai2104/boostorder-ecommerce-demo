var cart;

document.addEventListener('DOMContentLoaded', function () {
    // Get the cart data from the cookie
    var cartData = getCookie('cart');

    // If the cart data is not null
    if (cartData) {
        // Set the value to the cart variable
        cart = JSON.parse(cartData);
    } else {
        // Initiate the cart array
        cart = [];
    }

    console.log(cart)

    // Update the cart amount
    updateCartAmount();
})

function updateCartAmount() {
    // Get the cart badge
    var cartBadge = document.getElementById('badge-cart');

    var totalAmount = 0;

    if (cart.length) {
        // Count the quantity of the items in the cart
        cart.forEach(element => {
            // Add the qty to the total amount
            totalAmount += parseInt(element.qty);
        });

        // Update the cart badge
        cartBadge.innerHTML = totalAmount;
    }    
}

// Get the cookie by name
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}