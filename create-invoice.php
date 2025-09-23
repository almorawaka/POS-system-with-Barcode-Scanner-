<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Invoice</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Create Invoice</h2>

<!-- Customer Search Section -->
<h3>Customer Details</h3>
<label>Phone No:</label>
<input type="text" id="phone-search" placeholder="Enter phone number">
<button onclick="searchCustomer()">Search</button><br>

<label>Name:</label>
<input type="text" id="customer-name" readonly><br>
<label>Address:</label>
<input type="text" id="customer-address" readonly><br>

<!-- Item Input -->
<h3>Invoice Items</h3>
<label>Item Code:</label>
<input type="text" id="item-code" placeholder="Barcode or ID" autofocus>
<button onclick="addItem()">Add Item</button>

<table border="1" id="invoice-table">
    <thead>
        <tr>
            <th>Item Code</th><th>Name</th><th>Price</th><th>Qty</th><th>Total</th><th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<h3>Total: <span id="grand-total">0.00</span></h3>
<button onclick="submitInvoice()">Submit Invoice</button>

<script>
let invoiceItems = [];

function searchCustomer() {
    const phone = document.getElementById('phone-search').value;
    if (!phone) return;

    fetch(`fetch-customer.php?phone=${phone}`)
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                document.getElementById('customer-name').value = '';
                document.getElementById('customer-address').value = '';
            } else {
                document.getElementById('customer-name').value = data.name;
                document.getElementById('customer-address').value = data.address;
            }
        });
}

function addItem() {
    const code = document.getElementById('item-code').value;
    if (!code) return;

    fetch(`fetch-item.php?code=${code}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            const existing = invoiceItems.find(i => i.item_code === data.item_code);
            if (existing) {
                existing.qty += 1;
            } else {
                invoiceItems.push({ ...data, qty: 1 });
            }

            renderInvoice();
            document.getElementById('item-code').value = '';
        });
}

function renderInvoice() {
    const tbody = document.querySelector('#invoice-table tbody');
    tbody.innerHTML = '';
    let grandTotal = 0;

    invoiceItems.forEach((item, index) => {
        const total = item.qty * item.selling_price;
        grandTotal += total;
        const row = `
            <tr>
                <td>${item.item_code}</td>
                <td>${item.name}</td>
                <td>${item.selling_price}</td>
                <td><input type="number" value="${item.qty}" onchange="updateQty(${index}, this.value)"></td>
                <td>${total.toFixed(2)}</td>
                <td><button onclick="removeItem(${index})">Remove</button></td>
            </tr>`;
        tbody.innerHTML += row;
    });

    document.getElementById('grand-total').innerText = grandTotal.toFixed(2);
}

function updateQty(index, value) {
    invoiceItems[index].qty = parseInt(value);
    renderInvoice();
}

function removeItem(index) {
    invoiceItems.splice(index, 1);
    renderInvoice();
}

function submitInvoice() {
    const payload = {
        name: document.getElementById('customer-name').value,
        address: document.getElementById('customer-address').value,
        phone: document.getElementById('phone-search').value,
        total: parseFloat(document.getElementById('grand-total').innerText),
        items: invoiceItems.map(item => ({
            item_code: item.item_code,
            name: item.name,
            selling_price: item.selling_price,
            qty: item.qty,
            total: item.qty * item.selling_price
        }))
    };

    fetch('submit-invoice.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (data.invoice_number) {
            alert("Invoice saved successfully!");
            window.open(`print-invoice.php?invoice=${data.invoice_number}`, '_blank');
        } else {
            alert("Failed to save invoice.");
        }
    });
}
</script>

</body>
</html>
