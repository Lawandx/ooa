
function openModal() {
    document.getElementById('myModal').style.display = 'block';
}

window.onclick = function (event) {
    var modal = document.getElementById('myModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

function myaddModal() {
    document.getElementById('myaddModal').style.display = 'block';
}

window.onclick = function(event) {
    var modal = document.getElementById('myaddModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

function openReceipt() {
    document.getElementById('receiptModal').style.display = 'block';
}

window.onclick = function (event) {
    var modal = document.getElementById('receiptModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}


function loadPage(page) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("content").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", page, true);
    xhttp.send();
}

function deleteProduct(productId) {
    if (confirm("Are you sure you want to delete this product?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_product.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    location.reload();
                } else {
                    alert("An error occurred while deleting the product.");
                }
            }
        };
        xhr.send("productId=" + productId);
    }
}

function editProduct(productId) {
    fetch('get_product.php?id=' + productId)
        .then(response => response.json())
        .then(product => {
            document.getElementById('updateProductForm').setAttribute('action', 'update_product.php?id=' + productId);
            document.getElementById('productIDUpdate').value = product.id_products;
            document.getElementById('productNameUpdate').value = product.name;
            document.getElementById('productTypeUpdate').value = product.type;
            document.getElementById('productBarcodeUpdate').value = product.barcode;
            document.getElementById('productPriceUpdate').value = product.price;
            document.getElementById('productQuantityUpdate').value = product.quantity;
            document.getElementById('productStatusUpdate').value = product.status;
            openEditModal();
        })
        .catch(error => {
            console.error('Error:', error);
        });
}


function openEditModal() {
    const modal = document.getElementById('editModal');
    modal.style.display = 'block';
}

window.addEventListener('click', function (event) {
    var modal = document.getElementById('editModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});


function addToOrder(productId) {
    const product = document.querySelector(`.product-box[data-id='${productId}']`);
    const productName = product.querySelector('p:nth-of-type(1)').textContent.split(': ')[1];
    const productType = product.querySelector('p:nth-of-type(2)').textContent.split(': ')[1];
    const productPrice = product.querySelector('p:nth-of-type(3)').textContent.split(': ')[1];

    const orderTable = document.querySelector('#orderForm table');
    const newRow = orderTable.insertRow(-1);

    const cellName = newRow.insertCell(0);
    const cellType = newRow.insertCell(1);
    const cellPrice = newRow.insertCell(2);
    const cellQuantity = newRow.insertCell(3);
    const cellAction = newRow.insertCell(4);

    cellName.innerHTML = productName;
    cellType.innerHTML = productType;
    cellPrice.innerHTML = productPrice;
    cellQuantity.innerHTML = '<input type="number" class="form-control" name="quantity" style="max-width: 80px;" min="1" value="1">';
    cellAction.innerHTML = '<button class="btn btn-danger mb-3" onclick="removeFromOrder(this)">Remove</button>';
}
function removeFromOrder(button) {
    var row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}
function sendFormDataToServer() {
    const formData = new FormData(document.getElementById("orderForm"));

    const tableData = [];
    const table = document.getElementById("tableBody");
    for (let i = 0; i < table.rows.length; i++) {
        const row = table.rows[i];
        const inputElement = row.cells[3].querySelector('input');
        if (inputElement) {
            const rowData = {
                product_name: row.cells[0].innerText,
                product_type: row.cells[1].innerText,
                product_price: row.cells[2].innerText,
                quantity: inputElement.value
            };
            tableData.push(rowData);
        }
    }
    formData.append('tableData', JSON.stringify(tableData));

    fetch('add_to_order.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.order_id) {
                showInvoiceForm(data.order_id);
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
        });
}


function showInvoiceForm(orderID) {
    const invoiceForm = `
        <form id="invoiceForm" action="process_invoice.php" method="POST" style="padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
            <h3 style="text-align: center;">Invoice Form</h3>
            <input type="hidden" name="order_id" value="${orderID}">
            <label for="status">Status:</label>
            <input type="text" name="status" value="ยังไม่ได้จ่าย" readonly style="width: 100%; padding: 5px; margin-bottom: 10px;">
            <label for="discount">Discount:</label>
            <input type="text" name="discount" value="0" style="width: 100%; padding: 5px; margin-bottom: 10px;">
            <label for="note">Note:</label>
            <textarea name="note" style="width: 100%; padding: 5px;"></textarea>
            <input type="submit" value="Submit Invoice" style="width: 100%; padding: 10px; margin-top: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
        </form>
    `;

    document.getElementById("invoiceSection").innerHTML = invoiceForm;
}
function ResetPoint(customerId) {
    fetch(`reset_point.php?customer_id=${customerId}`)
        .then(response => {
            if (response.ok) {
                alert('Points reset successfully for customer ID: ' + customerId);
                location.reload(); // รีโหลดหน้าเว็บ
            } else {
                alert('Failed to reset points for customer ID: ' + customerId);
            }
        })
        .catch(error => {
            console.error('There was an error resetting points:', error);
            alert('Error occurred while resetting points');
        });
}
function deleteUser(customerId) {
    if (confirm("Are you sure you want to delete this user?")) {
        fetch(`delete_customer.php?customer_id=${customerId}`)
            .then(response => {
                if (response.ok) {
                    alert('User deleted successfully');
                    location.reload(); 
                } else {
                    alert('Failed to delete user');
                }
            })
            .catch(error => {
                console.error('There was an error deleting the user:', error);
                alert('Error occurred while deleting user');
            });
    }
}

function confirmDelete(id) {
    var deleteConfirm = confirm('Are you sure you want to delete this employee?');
    if (deleteConfirm) {
        // ส่งคำขอลบไปยัง delete_employee.php โดยใช้ Ajax
        // เช่น การใช้ fetch API หรือ XMLHttpRequest สำหรับการลบข้อมูลพนักงาน
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_employee.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // หลังจากลบสำเร็จ รีโหลดหน้าเพจ
                window.location.reload();
            }
        };
        xhr.send('id=' + id);
    }
}

function checkForNewBill() {
    fetch('check_new_bill.php')
        .then(response => response.json())
        .then(data => {
            if (data.newBillAvailable) {
                showNotification();
                showViewBillButton();
            }
        })
        .catch(error => {
            console.error('Error checking for new bill:', error);
        });
}

function showNotification() {
    const notification = document.getElementById('notification');
    notification.style.display = 'block';
}

function showViewBillButton() {
    const viewBillButton = document.getElementById('viewBillButton');
    if (viewBillButton) {
        viewBillButton.style.display = 'block';
    }
}

const viewBillButtons = document.querySelectorAll('.view-bill-button');
viewBillButtons.forEach(button => {
    button.addEventListener('click', function() {
        const billID = this.getAttribute('data-bill-id');
        viewBill(billID);
    });
});

function viewBill(billID) {
    window.location.href = 'view_bill.php?bill_id=' + billID; 
}
setInterval(checkForNewBill, 5000); 


function confirmDeletebd() {
    return confirm("คุณแน่ใจหรือไม่ว่าต้องการลบบิลนี้?");
}
function confirmDeletere() {
    return confirm("คุณแน่ใจหรือไม่ว่าต้องการลบใบเสร็จนี้?");
}