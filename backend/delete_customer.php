<?php
include_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    $customer = new Customer($conn);
    $isDeleted = $customer->deleteCustomer($customer_id);

    if ($isDeleted) {
        http_response_code(200); 
    } else {
        http_response_code(500); 
    }
}
?>
