<?php
include_once 'functions.php';


if (isset($_GET['receipt_id'])) {
    $receipt_id = $_GET['receipt_id'];


    $receipt = new Receipt($conn);
    $receiptDetails = $receipt->getReceiptDetails($receipt_id);
    $receiptCT = $receipt->getBill_CustomerDetails($receiptDetails['bill_id']);
    $receiptEM = $receipt->getBill_EmployeeDetails($receiptDetails['bill_id']);
    $billDetails = $receipt->getBillDetails($receiptDetails['bill_id']);
    $billProductDetails = $receipt->getBill_ProductDetails($receiptDetails['bill_id']);

    if ($receiptDetails) { ?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Receipt</title>
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
                    <p>28/3 หมู่ 9 ตำบลเนินขี้เหล็ก อำเภอลาดยาว จังหวัดนครสวรรค์</p>
                    <p>Employee: <?php echo $receiptEM['first_name'] ?> <?php echo $receiptEM['last_name'] ?>
                    <p>Customer: <?php echo $receiptCT['first_name'] ?> <?php echo $receiptCT['last_name'] ?>
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
                    ทั้งหมด (Total): <?php echo $billDetails['total_amount'] ?> Bath
                    </div>
                    <div class="total">
                    ส่วนลด (Discount): <?php echo $billDetails['discount'] ?> Bath
                    </div>
                    <div class="total">
                     ราคาที่ต้องจ่าย (Amount Due): <?php echo $billDetails['Pricetopay'] ?> Bath
                    </div>
                    <div class="total">
                    มูลค่าสินค้า (Product value): <?php echo $receiptDetails['Productvalue'] ?> Bath
                    </div>
                    <div class="total">
                    ภาษีมูลค่าเพิ่ม 7% (VAT 7%): <?php echo $receiptDetails['tax'] ?> Bath
                    </div>

                    <div class="total">
                    จำนวนเงินที่ได้รับ (Amount received): <?php echo $receiptDetails['Amount_received'] ?> Bath
                    </div>
                    <div class="total">
                     เงินทอน (change): <?php echo $receiptDetails['change'] ?> Bath
                    </div>
                    <div class="total">
                     สถานะ (Status): <?php echo $billDetails['status'] ?>
                    </div>

                    <div>
                    หมายเหตุ (note):
                    </div><br>
                    <div>
                        Invoice : <?php echo "$receipt_id" ?>&nbsp &nbsp Bill : <?php echo $receiptDetails['bill_id'] ?> &nbsp &nbsp Date & Time: <?php echo $receiptDetails['receipt_date'] ?>
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