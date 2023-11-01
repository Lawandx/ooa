<?php
include_once 'functions.php';
$product = new Product($conn);
$products = $product->getProducts();

$customer = new Customer($conn);
$customers = $customer->getCustomers();

$emplotyee = new Employee($conn);
$emplotyees = $emplotyee->getemployee();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cashier</title>
    <style>
        .product-box {
            width: 200px;
            height: auto;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .product-box img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .order-details {
            display: none;
        }

        .sidenav {
            height: 100%;
            width: 180px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            padding-top: 20px;
        }

        .sidenav a {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 20px;
            color: #818181;
            display: block;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

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




        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-0">Cashier</h1>
            <div class="d-flex">
                <button class="btn btn-primary" onclick="openModal()">AddPoint</button>
                <div style="margin-left: 5px; margin-right: 5px;"></div>
                <button class="btn btn-secondary " onclick="openReceipt()">Receipt</button>
            </div>
        </div>


        <div id="receiptModal" class="modal">
            <div class="modal-content">
                <form action="add_Receipt.php" method="POST" class="mb-3">
                    <div class="mb-3">
                        <label for="id_bill" class="form-label">id_bill</label>
                        <input type="text" class="form-control" id="id_bill" name="id_bill">
                    </div>
                    <div class="mb-3">
                        <label for="Amount_received" class="form-label">จำนวนเงินที่รับมา</label>
                        <input type="number" class="form-control" id="Amount_received" name="Amount_received">
                    </div>
                    <button type="submit" class="btn btn-primary">AddReceipt</button>
                </form>
            </div>
        </div>


        <div id="myModal" class="modal">
            <div class="modal-content">
                <form action="add_Point.php" method="POST" class="mb-3">
                    <div class="mb-3">
                        <label for="ID" class="form-label">ID</label>
                        <input type="text" class="form-control" id="ID" name="ID">
                    </div>
                    <div class="mb-3">
                        <label for="Point" class="form-label">Point</label>
                        <input type="number" class="form-control" id="Point" name="Point">
                    </div>

                    <button type="submit" class="btn btn-primary">AddPoint</button>
                </form>
            </div>
        </div>



        <form id="orderForm" action="#" method="POST">
            <div class="row mb-3">
                <div class="col-sm-1">
                    <label for="customer_id" class="form-label">Customer :</label>
                </div>
                <div class="col-sm-2">
                    <select class="form-select" name="customer_id" id="customer_id">
                        <?php while ($row = mysqli_fetch_array($customers)) { ?>
                            <option value="<?php echo $row['id_phone']; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-sm-1">
                    <label for="employee_id" class="form-label">Employee :</label>
                </div>
                <div class="col-sm-2">
                    <select class="form-select" name="employee_id" id="employee_id">
                        <?php while ($row = mysqli_fetch_array($emplotyees)) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <table class="table table-bordered table-striped" id="tableBody">
                <thead class="table-dark">
                    <tr>
                        <th>Product Name</th>
                        <th>Product Type</th>
                        <th>Product Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-light"></tbody>
            </table>
            <button type="button" class="btn btn-primary float-end" onclick="sendFormDataToServer()">Add Order</button>
        </form>
        <div id="invoiceSection"></div>
        <br><br>
        <h3>Product list</h3>
        <div class="row">
            <?php while ($row = mysqli_fetch_array($products)) { ?>
                <div class="col-3">
                    <div class="product-box border" data-id="<?php echo $row['id_products']; ?>">
                        <img src="<?php echo $row['image']; ?>" class="img-fluid" alt="Product Image">
                        <p>Name: <?php echo $row['name']; ?></p>
                        <p>Type: <?php echo $row['type']; ?></p>
                        <p>Price: <?php echo $row['price']; ?></p>
                        <button class="btn btn-warning" onclick="addToOrder(<?php echo $row['id_products']; ?>)">Add to Order</button>
                    </div>
                </div>
            <?php } ?>

        </div>
        
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="script.js"></script>
</body>

</html>