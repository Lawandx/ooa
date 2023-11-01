<?php
include_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $employee = new Employee($conn);

   
    $employeeId = $_POST['id'];

 
    $deleted = $employee->deleteEmployee($employeeId);

    if ($deleted) {
       
        http_response_code(200);
    } else {
       
        http_response_code(500);
    }

    $conn->close();
}
?>
