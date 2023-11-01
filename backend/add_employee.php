<?php
include_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee = new Employee($conn);

    $added = $employee->addEmployee(
        $_POST['firstName'],
        $_POST['lastName'],
        $_POST['phoneNumber'],
        $_POST['address'],
        $_POST['email'],
        $_POST['status'],
        $_POST['startDate']
    );

    if ($added) {
        // ใช้ JavaScript alert เพื่อแสดงข้อความ
        echo '<script>alert("Employee added successfully!");</script>';

        // โลเคชันไปยังหน้า Employees.php
        echo '<script>window.location = "Employees.php";</script>';
    } else {
        echo "Error adding employee.";
    }

    $conn->close();
}
?>
