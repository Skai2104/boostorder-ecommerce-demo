<?php
include "includes/header.php";

// Define the username, password and URL to access the API
define("API_USERNAME", "ck_2682b35c4d9a8b6b6effac126ac552e0bfb315a0");
define("API_PASSWORD", "cs_cab8c9a729dfb49c50ce801a9ea41b577c00ad71");
define("API_URL", "https://mangomart-autocount.myboostorder.com/wp-json/wc/v1/products");

// Default page = 1
$page = 1;

// Get the page parameter from the URL
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

// Function to get the product details from the API
// Parameter: page number
function getProducts($page)
{
    // Update the API URL with the page number
    $api_url = API_URL . '?page=' . $page;

    // Initialize the cURL
    $curl = curl_init();

    // Configure the cURL
    curl_setopt($curl, CURLOPT_URL, $api_url);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERPWD, API_USERNAME . ':' . API_PASSWORD);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    // Execute the cURL
    $response = curl_exec($curl);

    // Extract the headers of the response
    $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $header = getHeaders($header);

    // Get the total pages and total products from the headers
    $total_pages = $header['X-WP-TotalPages'];
    $total_products = $header['X-WP-Total'];

    // Extract body of the response
    $body = substr($response, $header_size);

    // Convert the body from string to array
    $body = json_decode($body);

    // Define an array to store the products
    $products = array();

    // Loop through the response
    foreach ($body as $item) {
        // Only if the catalog visibility is visible
        if ($item->catalog_visibility === 'visible') {
            // Instantiate an object of Product
            $product = new Product();

            // Assign the values
            $product->id = $item->id;
            $product->name = $item->name;
            $product->images = $item->images;

            // Push the object into the array
            array_push($products, $product);
        }
    }

    // Destroy the cURL instance
    curl_close($curl);

    // Encapsulate all the data in an array
    $data = array(
        "total_pages" => $total_pages,
        "total_products" => $total_products,
        "products" => $products
    );

    return $data;
}

// Function to get the headers in an accosiate array
function getHeaders($respHeaders)
{
    $headers = array();

    $headerText = substr($respHeaders, 0, strpos($respHeaders, "\r\n\r\n"));

    foreach (explode("\r\n", $headerText) as $i => $line) {
        if ($i === 0) {
            $headers['http_code'] = $line;
        } else {
            list($key, $value) = explode(': ', $line);

            $headers[$key] = $value;
        }
    }

    return $headers;
}

class Product
{
    public $id;
    public $name;
    public $images = array();
}

$data = getProducts($page);
?>

<h3 class="mt-4">Our Products</h3>
<hr>
<p class="text-center">Page <?= $page ?> of <?= $data['total_pages'] ?> pages</p>
<div class="row">
    <?php
    foreach ($data['products'] as $product) {
        echo
            '<div class="col-3 mb-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <img src="' . $product->images[0]->src . '" class="card-img-top img-product">
                        <h5 class="card-title text-product-name">' . $product->name . '</h5>
                        <small>Quantity:</small>
                        <div class="input-group mb-4 w-50 mx-auto">
                            <div class="input-group-prepend">
                                <button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon1" onclick="updateQty(\'input-' . $product->id . '\', false)">-</button>
                            </div>
                            <input id="input-' . $product->id . '" type="text" class="form-control text-center" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" value="1">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon1" onclick="updateQty(\'input-' . $product->id . '\', true)">+</button>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary" onclick="addToCart(\'' . $product->id . '\',\'' . $product->name . '\', \'' . $product->images[0]->src . '\')">Add to Cart</a>
                    </div>
                </div>
            </div>';
    }
    ?>
</div>
<!-- Pagination -->
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <?php
        for ($i = 1; $i <= $data['total_pages']; $i++) {
            // Default class name for page item
            $class_name = "page-item";

            // Set the page item to active for current page
            if ($i == $page) {
                $class_name = "page-item active";
            }

            echo "<li class='$class_name'><a class='page-link' href='index.php?page=$i'>$i</a></li>";
        }
        ?>

        <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>

<script>
    function updateQty(inputId, increment) {
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
        }
    }

    function addToCart(productId, productName, productImg) {
        // Get the quantity using the input ID
        var inputId = 'input-' + productId;
        var qty = document.getElementById(inputId).value;

        // Encapsulate the data into an object
        var cartItem = {
            productId: productId,
            productName: productName,
            productImg: productImg,
            qty: qty
        };

        // Add the cartItem to the cart array
        cart.push(cartItem);

        // Convert the cart into JSON string and save it in the cookie
        document.cookie = 'cart=' + JSON.stringify(cart);

        // Update the cart amount
        updateCartAmount();

        // Reset the quantity input to 1
        document.getElementById(inputId).value = 1;
    }
</script>

<?php
include "includes/footer.php";
?>