<?php
include 'functions.php';

if (isset($_GET['receipt_id'])) {
    $receipt_id = $_GET['receipt_id'];
    $receipt = new Receipt($conn);
    $result = $receipt->deletereceipt($receipt_id);

    if ($result == true) {
        echo '<script>alert("ลบเรียบร้อย");</script>';
        echo '<script>window.location.href = "history.php";</script>';
    } else {
        echo '<script>alert("ไม่สามารถลบบิลได้");</script>';
        echo '<script>window.location.href = "history.php";</script>';
    }
} else {
    echo "No bill ID provided for deletion";
}
?>
