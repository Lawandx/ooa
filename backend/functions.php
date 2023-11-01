<?php
$servername = "localhost";
$username = "root";
$password = "kosit130646";
$dbname = "cafe_ooa";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

class Product
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }
  public function addProduct($productName, $productType, $productBarcode, $productPrice, $productQuantity, $productStatus, $productImage)
  {
    $sql = "INSERT INTO products (name, type, barcode, price, quantity, status, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("sssdiss", $productName, $productType, $productBarcode, $productPrice, $productQuantity, $productStatus, $productImage);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }


  public function deleteProduct($productId)
  {
    $sql = "DELETE FROM products WHERE id_products = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function getProducts()
  {
    $sql = "SELECT * FROM products";
    $result = mysqli_query($this->conn, $sql);
    return $result;
  }

  public function getProductById($productId)
  {
    $sql = "SELECT * FROM products WHERE id_products = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
  }

  public function isProductBarcodeUnique($productBarcode)
  {
    $sql = "SELECT * FROM products WHERE barcode = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $productBarcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      return false;
    } else {
      return true;
    }
  }

  public function updateProduct($conn, $productId, $productName, $productType, $productBarcode, $productPrice, $productQuantity, $productStatus, $file_destination)
  {
    $sql = "UPDATE products 
        SET name = ?, 
        type = ?, 
        barcode = ?, 
        price = ?, 
        quantity = ?, 
        status = ?, 
        image = ? 
        WHERE id_products = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdissi", $productName, $productType, $productBarcode, $productPrice, $productQuantity, $productStatus, $file_destination, $productId);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function updateProductWithoutImage($conn, $productId, $productName, $productType, $productBarcode, $productPrice, $productQuantity, $productStatus)
  {
    $stmt = $conn->prepare("UPDATE products SET name = ?, type = ?, barcode = ?, price = ?, quantity = ?, status = ? WHERE id_products = ?");
    $stmt->bind_param("ssssssi", $productName, $productType, $productBarcode, $productPrice, $productQuantity, $productStatus, $productId);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
}

class Customer
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function getCustomers()
  {
    $sql = "SELECT * FROM customers";
    $result = mysqli_query($this->conn, $sql);
    return $result;
  }

  function addpoint($ID, $point)
  {
    $query = "UPDATE customers SET Point = Point + $point WHERE id_phone = $ID";
    $result = mysqli_query($this->conn, $query);

    if ($result) {
      return true;
    } else {
      return false;
    }
  }
  public function resetCustomerPoints($customer_id)
  {
    $sql = "UPDATE customers SET Point = CASE WHEN Point > 100 THEN Point - 100 ELSE 0 END WHERE id_phone = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function deleteCustomer($customer_id)
  {
    $sql = "DELETE FROM customers WHERE id_phone = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);

    if ($stmt->execute()) {
      return true; // ลบผู้ใช้งานสำเร็จ
    } else {
      return false; // ลบผู้ใช้งานไม่สำเร็จ
    }
  }
}
class Employee
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }
  public function getemployee()
  {
    $sql = "SELECT * FROM employees";
    $result = mysqli_query($this->conn, $sql);
    return $result;
  }
  public function addEmployee($firstName, $lastName, $phoneNumber, $address, $email, $status, $startDate)
  {
    $sql = "INSERT INTO employees ( first_name, last_name, phone_number, address, email, status, start_date) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);


    if (!$stmt) {
      return false;
    }


    $stmt->bind_param("sssssss",  $firstName, $lastName, $phoneNumber, $address, $email, $status, $startDate);

    // ส่งคำสั่ง SQL ไปให้ฐานข้อมูล
    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function deleteEmployee($id)
  {

    $sql = "DELETE FROM employees WHERE id = ?";


    $stmt = $this->conn->prepare($sql);


    $stmt->bind_param("s", $id);


    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function getEmployeeById($employeeId)
  {
    $sql = "SELECT * FROM employees WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $employeeId);

    if ($stmt->execute()) {
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // คืนค่าข้อมูลของพนักงานที่พบ
      } else {
        return null; // ถ้าไม่พบข้อมูลพนักงาน
      }
    } else {
      return null; // กรณีเกิดข้อผิดพลาดในการดึงข้อมูล
    }
  }
}
class Order
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function addOrder($customer_id, $employee_id)
  {
    $sql = "INSERT INTO orders (customer_id, employee_id) VALUES (?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("si", $customer_id, $employee_id);

    if ($stmt->execute()) {
      return $stmt->insert_id;
    } else {
      return false;
    }
  }

  public function addOrderItems($order_id, $product_name, $product_type, $product_price, $quantity)
  {
    $sql = "INSERT INTO order_items (order_id, product_name, product_type, product_price, quantity) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("isssd", $order_id, $product_name, $product_type, $product_price, $quantity);

    if ($stmt->execute()) {
      return $stmt->affected_rows > 0;
    } else {
      return false;
    }
  }


  public function calculateTotalAmountForOrder($order_id)
  {
    $sql = "SELECT SUM(product_price * quantity) AS total_amount FROM order_items WHERE order_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total_amount'];
  }
  public function getOrderDetails($order_id)
  {
    $sql = "SELECT * FROM orders WHERE order_id  = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row;
    } else {
      return false;
    }
  }

  public function getOrderItems($order_id)
  {
    $sql = "SELECT * FROM order_items WHERE order_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $orderItems = array();
      while ($row = $result->fetch_assoc()) {
        $orderItems[] = $row;
      }
      return $orderItems;
    } else {
      return false;
    }
  }
  public function getLatestOrder()
  {
    $sql = "SELECT * FROM orders ORDER BY order_id DESC LIMIT 1";
    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      return $result->fetch_assoc();
    } else {
      return null;
    }
  }
  public function getOrder()
  {
    $sql = "SELECT * FROM orders";
    $result = $this->conn->query($sql);
    if ($result && $result->num_rows > 0) {
      $orders = [];
      while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
      }
      return $orders;
    } else {
      return [];
    }
  }
  public function deleteorder($order_id)
  {
    $sql = "DELETE FROM orders WHERE order_id = $order_id";
    $result = mysqli_query($this->conn, $sql);
    if ($result) {
        return true;
    } else {
        return false;
    }
  }
}


class Bill extends Order
{
  private $conn;

  public function __construct($conn)
  {
    parent::__construct($conn);
    $this->conn = $conn;
  }

  public function addBill($order_id, $discount_percentage, $note, $status)
  {
    $total_amount = $this->calculateTotalAmountForOrder($order_id);
    $discount = ($total_amount * $discount_percentage) / 100;

    $Pricetopay = $total_amount - $discount;
    $currentDate = date("Y-m-d H:i:s");

    $sql = "INSERT INTO bill (order_id, total_amount, bill_date, discount, Pricetopay, note, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);

    if ($stmt === false) {
      return $this->conn->error;
    }

    $stmt->bind_param("idssdss", $order_id, $total_amount, $currentDate, $discount, $Pricetopay, $note, $status);

    if ($stmt->execute()) {
      return true;
    } else {
      return $stmt->error;
    }
  }
  public function getBill()
  {
    $sql = "SELECT * FROM bill";
    $result = mysqli_query($this->conn, $sql);
    return $result;
  }
  public function getBillDetails($bill_id)
  {
    $sql = "SELECT * FROM bill WHERE bill_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $bill_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      return $result->fetch_assoc();
    } else {
      return null;
    }
  }
  public function getBill_CustomerDetails($bill_id)
  {
    $sql = "SELECT bill.*, customers.first_name, customers.last_name
    FROM bill 
    INNER JOIN orders ON bill.order_id = orders.order_id
    INNER JOIN customers ON orders.customer_id = customers.id_phone
    WHERE bill.bill_id = ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $bill_id);

    if ($stmt->execute()) {
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        return $result->fetch_assoc();
      } else {
        return null;
      }
    } else {
      return null;
    }
  }
  public function getBill_EmployeeDetails($bill_id)
  {
    $sql = "SELECT bill.*, employees.first_name, employees.last_name
    FROM bill 
    INNER JOIN orders ON bill.order_id = orders.order_id
    INNER JOIN employees ON orders.employee_id  = employees.id
    WHERE bill.bill_id = ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $bill_id);

    if ($stmt->execute()) {
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        return $result->fetch_assoc();
      } else {
        return null;
      }
    } else {
      return null;
    }
  }
  public function getBill_ProductDetails($bill_id)
  {
    $sql = "SELECT order_items.product_name, order_items.product_type, order_items.product_price, order_items.quantity
    FROM bill 
    INNER JOIN orders ON bill.order_id = orders.order_id
    INNER JOIN order_items ON orders.order_id = order_items.order_id
    WHERE bill.bill_id = ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $bill_id);

    if ($stmt->execute()) {
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
          $rows[] = $row;
        }
        return $rows;
      } else {
        return null;
      }
    } else {
      return null;
    }
  }
  public function getPricetopay($bill_id)
  {
    $sql = "SELECT Pricetopay FROM bill WHERE bill_id = ?";
    $stmt = $this->conn->prepare($sql);

    if ($stmt === false) {
      return "Error: " . $this->conn->error;
    }

    $stmt->bind_param("i", $bill_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['Pricetopay'];
    } else {
      return "Error: No data found for the provided bill_id";
    }
  }
  public function deleteBill($bill_id)
  {
    $sql = "DELETE FROM bill WHERE bill_id = $bill_id";
    $result = mysqli_query($this->conn, $sql);
    if ($result) {
      return true;
    } else {
      return false;
    }
  }
}

class Receipt extends Bill
{
  private $conn;

  public function __construct($conn)
  {
    parent::__construct($conn);
    $this->conn = $conn;
  }
  public function deletereceipt($receipt_id)
  {
    $sql = "DELETE FROM receipt WHERE receipt_id = $receipt_id";
    $result = mysqli_query($this->conn, $sql);
    if ($result) {
      return true;
    } else {
      return false;
    }
  }
  public function getReceipt()
  {
    $sql = "SELECT * FROM receipt";
    $result = mysqli_query($this->conn, $sql);
    return $result;
  }
  public function createReceipt($bill_id, $Amount_received)
  {
    $Pricetopay = $this->getPricetopay($bill_id);
    $tax = $Pricetopay * 0.07;
    $Productvalue = $Pricetopay - $tax;

    $change = $Amount_received - $Pricetopay;

    $sql_insert_receipt = "INSERT INTO receipt (bill_id, Amount_received, `change`, tax, Productvalue, receipt_date) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt_insert_receipt = $this->conn->prepare($sql_insert_receipt);

    if ($stmt_insert_receipt === false) {
      return "Error: " . $this->conn->error;
    }

    $stmt_insert_receipt->bind_param("idddd", $bill_id, $Amount_received, $change, $tax, $Productvalue);

    if ($stmt_insert_receipt->execute()) {
      $sql_update_bill = "UPDATE bill SET status = 'จ่ายแล้ว' WHERE bill_id = ?";
      $stmt_update_bill = $this->conn->prepare($sql_update_bill);

      if ($stmt_update_bill === false) {
        return "Error: " . $this->conn->error;
      }

      $stmt_update_bill->bind_param("i", $bill_id);

      if ($stmt_update_bill->execute()) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }




  public function getReceiptDetails($receipt_id)
  {
    $sql = "SELECT * FROM receipt WHERE receipt_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $receipt_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      return $result->fetch_assoc();
    } else {
      return false;
    }
  }
  public function checkIfReceiptExistsWithBillID($bill_id)
  {
    $sql = "SELECT * FROM receipt WHERE bill_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $bill_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }
  public function checkIfBillExists($bill_id)
  {
    $sql = "SELECT * FROM bill WHERE bill_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $bill_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }
}
