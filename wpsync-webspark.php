<?php
/**
 * Plugin Name: wpsync-webspark
 * Description: The plugin receives product balances through the API
 * Version: 1.0
 * Author: Oleksandr Burkhan
 *
 */

define("WP_USE_THEMES", false);
require_once('../../../wp-blog-header.php');
require 'vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\RetryableHttpClient;

$apiURL = 'https://wp.webspark.dev/wp-api/products/';
$client = new RetryableHttpClient(HttpClient::create());

$response = $client->request('GET', $apiURL, [
    'timeout' => 20,
]);

$statusCode = $response->getStatusCode();
var_dump($statusCode);








// TODO get all products
//$products = wc_get_products(['status' => 'publish', 'limit' => -1]);
//var_dump($products);

// TODO get $content sku

// TODO get $products sku

// TODO find removed products by sku
// TODO find new products by sku
// TODO find update products by sku

// TODO loop $content
// TODO in loop check products.sku and products.sku
// TODO in loop if exists - update product
// TODO in loop if does not - create new product

// TODO create new product
//$post_id = wp_insert_post(array(
//    'post_title' => $title,
//    'post_type' => 'product',
//    'post_status' => 'publish',
//    'post_content' => $body,
//));
//$product = wc_get_product($post_id);
//$product->set_sku($sku);
//$product->set_price($price);
//$product->set_regular_price($regular_price);
//$product->save();