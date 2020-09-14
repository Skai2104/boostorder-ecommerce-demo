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

    // Update the cart amount
    updateCartAmount();

    // Check for notifications
    checkNotifications();
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

// Check for notifications
function checkNotifications() {
    $.get('api/check-notification.php', result => {
        // Convert the result from JSON string to array
        result = JSON.parse(result);

        var child;

        // Update the notification badge
        document.getElementById('badge-notification').innerHTML = result.length;

        // Reset the notification dropdown
        $('#dropdown-notification').empty();

        // If there is any notifications
        if (result.length) {
            // Loop through the array
            result.forEach(element => {
                child = '\
                    <a class="dropdown-item" href="orderDetails.php?orderId=' + element.order_id + '">\
                        Your order <b>#' + element.order_id + '</b> has updated its status to \
                        <b>' + element.status + '</b><br>\
                        <small class="text-muted">' + element.updated_at + '</small>\
                    </a>\
                    <div class="dropdown-divider"></div>\
                ';

                $('#dropdown-notification').append(child);
            });
        } else {
            // Display the message
            child = '<a class="dropdown-item disabled">You don\'t have any notifications at the moment.</a>';

            $('#dropdown-notification').append(child);
        }
    });
}

// Check for notifications every 3 seconds
setInterval(checkNotifications, 3000);