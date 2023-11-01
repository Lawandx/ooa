<?php
include_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['ID']) && isset($_POST['Point'])) {
        $ID = $_POST['ID'];
        $point = $_POST['Point'];

        $add = new Customer($conn);
        $result = $add->addpoint($ID, $point);

        if ($result === true) {
            echo '<script>alert("เพิ่มคะแนนสำเร็จ!"); window.location.href = "Orders.php";</script>';
        } else {
            header("HTTP/1.1 500 Internal Server Error");
            echo '<script>alert("เกิดข้อผิดพลาดในการเพิ่มคะแนน: ' . $result . '"); window.location.href = "Orders.php";</script>';            
        }
    } else {
        echo '<script>alert("ไม่ได้รับข้อมูล ID หรือ Point!"); window.location.href = "Orders.php";</script>';
    }
} else {
    echo '<script>alert("คำขอไม่ถูกต้อง"); window.location.href = "Orders.php";</script>'; 
}
?>
