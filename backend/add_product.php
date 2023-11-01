<?php
include_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $productType = $_POST['productType'];
    $productBarcode = $_POST['productBarcode'];
    $productPrice = $_POST['productPrice'];
    $productQuantity = $_POST['productQuantity'];
    $productStatus = $_POST['productStatus'];
    $product = new Product($conn);
    $isBarcodeUnique = $product->isProductBarcodeUnique($productBarcode);

    if ($isBarcodeUnique) {
        if ($_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['productImage'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];

            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($fileExt, $allowed)) {
                $fileDestination = 'uploads/' . $fileName;
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $productAdded = $product->addProduct($productName, $productType, $productBarcode, $productPrice, $productQuantity, $productStatus, $fileDestination);
                    if ($productAdded) {
                        header("Location:Products.php");
                        exit();
                    } else {
                        echo '<script>alert("Unable to add. Please try again."); window.location.href = "Products.php";</script>';
                    }
                } else {
                    echo '<script>alert("An error occurred uploading the file."); window.location.href = "Products.php";</script>';
                }
            } else {
                echo '<script>alert("Invalid file type (Can upload files with extensions jpg, jpeg, png, gif only)"); window.location.href = "Products.php";</script>';
            }
        } else {
            echo '<script>alert("There was an error uploading the file."); window.location.href = "Products.php";</script>';
        }
    } else {
        echo '<script>alert("Duplicate Barcode Please enter a unique Barcode."); window.location.href = "Products.php";</script>';
    }
}
?>
