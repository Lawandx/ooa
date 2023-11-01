<?php
include_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_bill"]) && isset($_POST["Amount_received"])) {
        $id_bill = $_POST["id_bill"];
        $Amount_received = $_POST["Amount_received"];

        // Check if the id_bill exists in the database or in records
        $receipt = new Receipt($conn);
        $receiptExists = $receipt->checkIfReceiptExistsWithBillID($id_bill);

        if ($receiptExists) {
            echo '<script>alert("Please see history in the system."); window.location.href = "Orders.php";</script>';
            exit();
        } else {
            // If the receipt doesn't exist for the bill, proceed with creating the receipt
            $receipt = new Receipt($conn);
            $receiptStatus = $receipt->createReceipt($id_bill, $Amount_received);

            if ($receiptStatus === true) {
                $sql = "SELECT MAX(receipt_id) AS latest_receipt_id FROM receipt WHERE bill_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id_bill);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $lastInsertedId = $row['latest_receipt_id'];

                    header("Location: pageReceipt.php?receipt_id=$lastInsertedId");
                    exit();
                } else {
                    echo "Error: Unable to retrieve latest Receipt ID.";
                }
            } else {
                echo "Error: " . $receiptStatus;
            }
        }
    } else {
        echo "Error: Incomplete data.";
    }
} else {
    echo "Error: Invalid request method.";
}

?>
