<?php
include_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id'], $_POST['discount'], $_POST['note'], $_POST['status'])) {
        $order_id = $_POST['order_id'];
        $discount = $_POST['discount'];
        $note = $_POST['note'];
        $status = $_POST['status'];

        $bill = new Bill($conn);
        $result = $bill->addBill($order_id, $discount, $note, $status);

        
        $sql = "SELECT MAX(bill_id) AS latest_bill_id FROM bill";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $latest_bill_id = $row['latest_bill_id'];
            header("Location: page.php?bill_id=$latest_bill_id");
        } else {
            echo "ไม่พบข้อมูลบิล";
        }
    } else {
        echo "กรุณากรอกข้อมูลที่จำเป็นให้ครบ";
    }
}
?>
