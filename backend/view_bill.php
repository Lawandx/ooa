<?php
include_once 'functions.php';

$billID = $_GET['bill_id'];
if (isset($_GET['bill_id'])) {
    $bill_id = $_GET['bill_id'];


    $bill = new Bill($conn);
    $billDetails = $bill->getBillDetails($bill_id);
    $billCustomer = $bill->getBill_CustomerDetails($bill_id);
    $billemployee = $bill->getBill_EmployeeDetails($bill_id);
    $billProductDetails = $bill->getBill_ProductDetails($bill_id);

    if ($billDetails && $billProductDetails) { ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Invoice</title>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }

                .invoice {
                    width: 800px;
                    margin: 20px auto;
                    border: 1px solid #ccc;
                    padding: 20px;
                }

                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }

                .info {
                    margin-bottom: 20px;
                }

                .info p {
                    margin: 5px 0;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }

                table,
                th,
                td {
                    border: 1px solid #000;
                }

                th,
                td {
                    padding: 8px;
                    text-align: left;
                }

                .total {
                    text-align: right;
                    margin-bottom: 20px;
                }

                .button-row {
                    width: 100%;
                    display: flex;
                    justify-content: space-between;
                    margin-top: 20px;

                }

                button {
                    padding: 10px 20px;
                    margin-right: 10px;
                    border: none;
                    background-color: #4CAF50;
                    /* สีพื้นหลังปุ่ม */
                    color: white;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    cursor: pointer;
                }

                button:hover {
                    background-color: #45a049;
                }
            </style>

        </head>

        <body>
            <div class="invoice">
                <div class="header">
                    <h1>Espresso bar</h1>
                </div>
                <div class="info">
                    <p>Address: 28/3 หมู่ 9 ตำบลเนินขี้เหล็ก อำเภอลาดยาว จังหวัดนครสวรรค์
                    </p>
                    <p>Employee: <?php echo $billemployee['first_name']; ?> <?php echo $billemployee['last_name']; ?></p>
                    <p>Customer: <?php echo $billCustomer['first_name']; ?> <?php echo $billCustomer['last_name']; ?></p>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($billProductDetails as $productDetail) { ?>
                            <tr>
                                <td><?php echo $productDetail['product_name']; ?></td>
                                <td><?php echo $productDetail['product_type']; ?></td>
                                <td><?php echo $productDetail['product_price']; ?></td>
                                <td><?php echo $productDetail['quantity']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
                <div class="total">
                    Total: <?php echo $billDetails['total_amount'] ?> Bath
                </div>
                <div class="total">
                    Discount: <?php echo $billDetails['discount'] ?> Bath
                </div>
                <div class="total">
                    Amount Due: <?php echo $billDetails['Pricetopay'] ?> Bath
                </div>
                <div class="total">
                    Status: <?php echo $billDetails['status'] ?>
                </div>
                <div>
                    note: <?php echo $billDetails['note'] ?>
                </div><br>
                <div>
                    Invoice : <?php echo "$bill_id" ?> &nbsp &nbsp Order : <?php echo $billDetails['order_id'] ?> &nbsp &nbsp Date & Time: <?php echo $billDetails['bill_date'] ?>
                </div><br>

                <div class="button-row">
                    <button><a href="history.php" style="text-decoration: none; color: white;">Back</a></button>
                    <button id="downloadButton">Download as PDF</button>
                </div>
            </div>
            <script>
                document.getElementById('downloadButton').addEventListener('click', function() {
                    var doc = new jsPDF();
                    var invoiceContent = document.querySelector('.invoice').outerHTML;
                    doc.fromHTML(invoiceContent, 15, 15);
                    doc.save('invoice.pdf');
                });
            </script>

            </div>

        </body>

        </html>

<?php  } else {
        echo "ไม่พบข้อมูลบิล";
    }
} else {
    echo "ไม่พบรหัสบิล";
}
?>