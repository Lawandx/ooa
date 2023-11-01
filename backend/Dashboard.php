<?php
include_once 'functions.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<header></header>

<body>
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
    <div id="content" class="content">
        <h1>Welcomel/h1>
    </div>
</div>
    <script src="script.js"></script>
</body>

</html>