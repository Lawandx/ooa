<?php
include_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    
    $customer = new Customer($conn);
    $result = $customer->resetCustomerPoints($customer_id);

    if ($result) {
       
        http_response_code(200);
        echo "Points reset successfully for customer ID: $customer_id";
    } else {
       
        http_response_code(500);
        echo "Failed to reset points for customer ID: $customer_id";
    }
} else {
   
    http_response_code(400);
    echo "Invalid request. Please provide a valid customer ID.";
}
?>
