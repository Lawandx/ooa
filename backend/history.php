<?php
include_once 'functions.php';


$receipt = new Receipt($conn);
$bills = $receipt->getBill();
$receipts = $receipt->getReceipt();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>History Information</title>

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

        <h2 class="my-4">History Bill</h2>
        <div id="notification" style="display: none;" class="alert alert-success">
            New bill available!
            <?php foreach ($bills as $bill) : ?>
                <?php if ($bill['status'] === 'ยังไม่ได้จ่าย') : ?>
                    <button class="btn btn-primary view-bill-button" data-bill-id="<?php echo $bill['bill_id']; ?>">View Bill</button>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order</th>
                        <th>Total_Amount</th>
                        <th>Discount</th>
                        <th>Pricetopay</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bills as $billss) { ?>
                        <tr>
                            <td><?php echo $billss['bill_id']; ?></td>
                            <td><?php echo $billss['order_id']; ?></td>
                            <td><?php echo $billss['total_amount']; ?></td>
                            <td><?php echo $billss['discount']; ?></td>
                            <td><?php echo $billss['Pricetopay']; ?></td>
                            <td><?php echo $billss['note']; ?></td>
                            <td><?php echo $billss['status']; ?></td>
                            <td><?php echo $billss['bill_date']; ?></td>
                            <td>
                                <a href="view_bill.php?bill_id=<?php echo $billss['bill_id']; ?>">
                                    <button class="btn btn-success">View Bill</button>
                                </a>
                            </td>
                            <td>
                                <a href="delete_bill.php?bill_id=<?php echo $billss['bill_id']; ?>" onclick="return confirmDeletebd();">
                                    <button class="btn btn-danger">Delete</button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <h2 class="my-4">History Receipt</h2>

        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bill</th>
                        <th>Amount Received</th>
                        <th>Change</th>
                        <th>VAT</th>
                        <th>Productvalue</th>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($receipts as $receiptss) { ?>
                        <tr>
                            <td><?php echo $receiptss['receipt_id']; ?></td>
                            <td><?php echo $receiptss['bill_id']; ?></td>
                            <td><?php echo $receiptss['Amount_received']; ?></td>
                            <td><?php echo $receiptss['change']; ?></td>
                            <td><?php echo $receiptss['tax']; ?></td>
                            <td><?php echo $receiptss['Productvalue']; ?></td>
                            <td><?php echo $receiptss['receipt_date']; ?></td>
                            <td>
                                <a href="view_receipt.php?receipt_id=<?php echo $receiptss['receipt_id']; ?>">
                                    <button class="btn btn-success">View receipt</button>
                                </a>
                            </td>
                            <td>
                                <a href="delete_receipt.php?receipt_id=<?php echo $receiptss['receipt_id']; ?> " onclick="return confirmDeletere();">
                                    <button class="btn btn-danger">Delete</button>
                                </a>
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