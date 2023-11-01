<?php
include 'functions.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $receipt = new Receipt($conn);
    $result = $receipt->deleteorder($order_id);

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
