<?php
include_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $employee_id = $_POST['employee_id'];
    $tableData = json_decode($_POST['tableData'], true);

    $order = new Order($conn);

    $orderAdded = $order->addOrder($customer_id, $employee_id);

    if (!is_string($orderAdded)) {
        $order_id = $orderAdded;
        $errorFlag = false;
        $totalAmount = 0;

        foreach ($tableData as $row) {
            $product_name = $row['product_name'];
            $product_type = $row['product_type'];
            $product_price = $row['product_price'];
            $quantity = $row['quantity'];

            $orderItemAdded = $order->addOrderItems($order_id, $product_name, $product_type, $product_price, $quantity);

            if (is_string($orderItemAdded)) {
                $errorFlag = true; 
                break; 
            }

            $totalAmount += $product_price * $quantity;
        }

        if ($errorFlag) {
            echo 'Error: There was an issue adding Order Items';
        } else {
            // Generate an array containing the order_id
            echo json_encode(array('order_id' => $order_id));
        }
    } else {
        echo 'Error: ' . $orderAdded;
    }
}
?>
