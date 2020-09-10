<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MainController extends Controller
{
    // The main function to get the product details via API
    // and display them on the page
    public function index($page)
    {
        // Initiate the Guzzle client for API request
        $client = new Client();

        // Construct the url for the API request based on the page
        $requestUrl = 'https://mangomart-autocount.myboostorder.com/wp-json/wc/v1/products?page=' . $page;

        // Get the response from the API
        $response = $client->request('GET', $requestUrl, ['auth' => ['ck_2682b35c4d9a8b6b6effac126ac552e0bfb315a0', 'cs_cab8c9a729dfb49c50ce801a9ea41b577c00ad71']]);

        // Get the total number of products from the response headers
        $totalProducts = $response->getHeader('X-WP-Total')[0];

        // Get the total pages from the response headers
        $totalPages = $response->getHeader('X-WP-TotalPages')[0];

        // Get the content body of the response
        $body = $response->getBody()->getContents();

        // Convert the response string to array
        $body = json_decode($body);

        return view('home')
            ->with('products', $body)
            ->with('totalProducts', $totalProducts)
            ->with('totalPages', $totalPages)
            ->with('page', $page);
    }
}
