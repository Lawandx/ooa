<?php

define('DB_SERVER', 'localhost'); // Your hostname
define('DB_USER', 'root'); // Database Username
define('DB_PASS', 'kosit130646'); // Database Password
define('DB_NAME', 'cafe_ooa'); // Database Name

class DB_con
{
    private $dbcon;

    public function __construct()
    {
        $this->dbcon = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        if ($this->dbcon->connect_error) {
            die("Connection failed: " . $this->dbcon->connect_error);
        }
    }



    public function registration($id_phone, $first_name, $last_name, $email, $password, $point, $updated_at)
    {
        $sql = "INSERT INTO customers (id_phone, first_name, last_name, email, password, point, updated_at) VALUES ('$id_phone', '$first_name', '$last_name', '$email', '$password' , '$point', '$updated_at')";
        if ($this->dbcon->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function signin($id_phone, $password)
    {
        $stmt = $this->dbcon->prepare("SELECT id_phone, first_name, last_name, password,email,Point,updated_at,profile_extension FROM customers WHERE id_phone = ? ");
        $stmt->bind_param("s", $id_phone);
        $stmt->execute();

        return $stmt->get_result();
    }
    public function seCustomers()
    {
        $secs = mysqli_query($this->dbcon, "SELECT * FROM customers WHERE id_phone");
        return $secs;
    }
    // Function to update the user's profile image
    public function updateProfileImage($id_phone, $imagePath)
    {
        $query = "UPDATE customers SET profile_extension = ? WHERE id_phone = ?";
        $stmt = $this->dbcon->prepare($query);
        $stmt->bind_param("si", $imagePath, $id_phone);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getUserProfileImage($id_phone)
    {
        $stmt = $this->dbcon->prepare("SELECT profile_extension FROM customers WHERE id_phone = ?");
        $stmt->bind_param("s", $id_phone);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($profileImage);
            $stmt->fetch();
            return $profileImage;
        } else {
            return false; // User not found or no profile image available
        }
    }
    public function add_Product($id_products, $name, $description, $image, $type, $price, $quantity, $status)
    {
        $query = "INSERT INTO products (id_products, name, description, image, type, price, quantity, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbcon->prepare($query);
        $stmt->bind_param("dssssdis", $id_products, $name, $description, $image, $type, $price, $quantity, $status);

        if ($stmt->execute()) {
            return true; // Product added successfully
        } else {
            return false; // Failed to add the product
        }
    }
}
