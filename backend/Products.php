<?php
include_once 'functions.php';
$product = new Product($conn);
$products = $product->getProducts();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Products Information</title>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }
    </style>
</head>

<body>
    <div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Cafe</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="customers.php" onclick="loadPage('customers')">Customers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="products.php" onclick="loadPage('products')">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="orders.php" onclick="loadPage('orders')">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="employees.php" onclick="loadPage('employees')">Employees</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="history.php" onclick="loadPage('employees')">History</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <h2 class="my-4">Products Information</h2>
        <div class="text-end mb-3">
            <button class="btn btn-primary" onclick="openModal()">Add Product</button>
        </div>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <form action="add_product.php" method="POST" enctype="multipart/form-data" id="productForm" class="mb-3">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName">
                    </div>
                    <div class="mb-3">
                        <label for="productType" class="form-label">Product Type</label>
                        <select class="form-select" id="productType" name="productType">
                            <option value="Hot">Hot</option>
                            <option value="Cold">Cold</option>
                            <option value="Spin">Spin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productBarcode" class="form-label">Product Barcode</label>
                        <input type="text" class="form-control" id="productBarcode" name="productBarcode">
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Product Price</label>
                        <input type="text" class="form-control" id="productPrice" name="productPrice">
                    </div>
                    <div class="mb-3">
                        <label for="productQuantity" class="form-label">Product Quantity</label>
                        <input type="text" class="form-control" id="productQuantity" name="productQuantity">
                    </div>
                    <div class="mb-3">
                        <label for="productStatus" class="form-label">Product Status</label>
                        <select class="form-select" id="productStatus" name="productStatus">
                            <option value="active">Active</option>
                            <option value="not_available">Not Available</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="productImage" name="productImage">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
        <div id="editModal" class="modal">
            <div class="modal-content">
                <form action="update_product.php" method="POST" enctype="multipart/form-data" id="updateProductForm" class="mb-3">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product ID</label>
                        <input type="text" class="form-control" id="productIDUpdate" name="productIDUpdate" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productNameUpdate" name="productNameUpdate">
                    </div>
                    <div class="mb-3">
                        <label for="productType" class="form-label">Product Type</label>
                        <select class="form-select" id="productTypeUpdate" name="productTypeUpdate">
                            <option value="Hot">Hot</option>
                            <option value="Cold">Cold</option>
                            <option value="Spin">Spin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productBarcode" class="form-label">Product Barcode</label>
                        <input type="text" class="form-control" id="productBarcodeUpdate" name="productBarcodeUpdate">
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Product Price</label>
                        <input type="text" class="form-control" id="productPriceUpdate" name="productPriceUpdate">
                    </div>
                    <div class="mb-3">
                        <label for="productQuantity" class="form-label">Product Quantity</label>
                        <input type="text" class="form-control" id="productQuantityUpdate" name="productQuantityUpdate">
                    </div>
                    <div class="mb-3">
                        <label for="productStatus" class="form-label">Product Status</label>
                        <select class="form-select" id="productStatusUpdate" name="productStatusUpdate">
                            <option value="active">Active</option>
                            <option value="not_available">Not Available</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="productImageUpdate" name="productImageUpdate">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </form>
            </div>
        </div>
        <?php
        if ($products->num_rows > 0) {
        ?>
            <table class="table table-striped table-hover">
                <thead>
                    <th>ID</th>
                    <th>image</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Barcode</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $products->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id_products']; ?></td>
                            <td><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" width="50" height="50"></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['type']; ?></td>
                            <td><?php echo $row['barcode']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td><?php echo $row['updated_at']; ?></td>
                            <td><button class="btn btn-primary" onclick="editProduct(<?php echo $row['id_products']; ?>)">Edit</button></td>
                            <td><button class="btn btn-danger" onclick="deleteProduct(<?php echo $row['id_products']; ?>)">Delete</button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else {
            echo "No products found.";
        } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>