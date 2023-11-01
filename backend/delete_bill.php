<?php
include 'functions.php';

if (isset($_GET['bill_id'])) {
    $bill_id = $_GET['bill_id'];
    $receipt = new Receipt($conn);
    $result = $receipt->deleteBill($bill_id);

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
