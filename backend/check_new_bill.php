<?php
function checkForNewBill()
{
    $servername = "localhost";
    $username = "root";
    $password = "kosit130646";
    $dbname = "cafe_ooa";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $newBillAvailable = false;

        // Check for bills with the status "ยังไม่ได้จ่าย"
        $sql = "SELECT COUNT(*) AS new_bills_count FROM bill WHERE status = 'ยังไม่ได้จ่าย'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['new_bills_count'] > 0) {
            $newBillAvailable = true;
        }

        
        echo json_encode(['newBillAvailable' => $newBillAvailable]);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    }
}


checkForNewBill();
