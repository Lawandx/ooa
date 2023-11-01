<?php
include_once 'functions.php';

$customer = new Customer($conn);
$customers = $customer->getCustomers();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Customers Information</title>
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
        <h2 class="my-4">Customers Information</h2>

        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Points</th>
                        <th>Last Updated</th>
                        <th>Action</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer) { ?>
                        <tr>
                            <td><?php echo $customer['id_phone']; ?></td>
                            <td><?php echo $customer['first_name']; ?></td>
                            <td><?php echo $customer['last_name']; ?></td>
                            <td><?php echo $customer['email']; ?></td>
                            <td><?php echo $customer['Point']; ?></td>
                            <td><?php echo $customer['updated_at']; ?></td>
                            <td>
                                <button class="btn btn-warning" onclick="ResetPoint(<?php echo $customer['id_phone']; ?>)">ResetPoint</button>
                            </td>
                            <td>
                            <button class="btn btn-danger" onclick="deleteUser(<?php echo $customer['id_phone']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>