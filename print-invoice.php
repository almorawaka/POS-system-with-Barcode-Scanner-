<?php
include 'db.php';
if (!isset($_GET['invoice'])) {
    die("Invoice number not provided.");
}
$invoice_number = $_GET['invoice'];
// Fetch invoice
$stmt = $conn->prepare("SELECT * FROM invoices WHERE invoice_number = ?");
$stmt->bind_param("s", $invoice_number);
$stmt->execute();
$invoice_result = $stmt->get_result();
$invoice = $invoice_result->fetch_assoc();
if (!$invoice) {
    die("Invoice not found.");
}
// Fetch invoice items
$invoice_id = $invoice['id'];
$item_result = $conn->query("SELECT * FROM invoice_items WHERE invoice_id = $invoice_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice <?php echo $invoice_number; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
            padding: 20px;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .invoice-header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 30px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }
        
        .invoice-header h1 {
            font-size: 2.5em;
            font-weight: 300;
            letter-spacing: 3px;
            margin-bottom: 10px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .company-logo {
            width: 80px;
            height: 80px;
            position: relative;
            animation: rotate 10s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .swirl-element {
            position: absolute;
            border-radius: 50px;
            transform-origin: center;
        }
        
        .swirl-1 { width: 25px; height: 8px; background: #e91e63; top: 5px; left: 15px; transform: rotate(-30deg); }
        .swirl-2 { width: 20px; height: 6px; background: #f44336; top: 2px; left: 35px; transform: rotate(10deg); }
        .swirl-3 { width: 22px; height: 7px; background: #00bcd4; top: 8px; left: 50px; transform: rotate(45deg); }
        .swirl-4 { width: 18px; height: 6px; background: #ff5722; top: 20px; left: 58px; transform: rotate(80deg); }
        .swirl-5 { width: 20px; height: 7px; background: #ffc107; top: 35px; left: 55px; transform: rotate(120deg); }
        .swirl-6 { width: 16px; height: 5px; background: #1976d2; top: 48px; left: 45px; transform: rotate(150deg); }
        .swirl-7 { width: 24px; height: 8px; background: #00acc1; top: 55px; left: 28px; transform: rotate(180deg); }
        .swirl-8 { width: 18px; height: 6px; background: #ffc107; top: 58px; left: 10px; transform: rotate(210deg); }
        .swirl-9 { width: 20px; height: 7px; background: #f44336; top: 50px; left: -2px; transform: rotate(240deg); }
        .swirl-10 { width: 16px; height: 5px; background: #e91e63; top: 38px; left: -5px; transform: rotate(270deg); }
        .swirl-11 { width: 22px; height: 7px; background: #00bcd4; top: 25px; left: 2px; transform: rotate(300deg); }
        .swirl-12 { width: 18px; height: 6px; background: #1976d2; top: 12px; left: 8px; transform: rotate(330deg); }
        
        .invoice-content {
            padding: 40px;
        }
        
        .company-info {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #3498db;
            display: flex;
            align-items: center;
            gap: 25px;
        }
        
        .company-logo-info {
            width: 60px;
            height: 60px;
            position: relative;
            flex-shrink: 0;
        }
        
        .company-logo-info .swirl-element {
            position: absolute;
            border-radius: 50px;
            transform-origin: center;
        }
        
        .company-logo-info .swirl-1 { width: 18px; height: 6px; background: #e91e63; top: 4px; left: 11px; transform: rotate(-30deg); }
        .company-logo-info .swirl-2 { width: 15px; height: 4px; background: #f44336; top: 2px; left: 26px; transform: rotate(10deg); }
        .company-logo-info .swirl-3 { width: 16px; height: 5px; background: #00bcd4; top: 6px; left: 37px; transform: rotate(45deg); }
        .company-logo-info .swirl-4 { width: 13px; height: 4px; background: #ff5722; top: 15px; left: 43px; transform: rotate(80deg); }
        .company-logo-info .swirl-5 { width: 15px; height: 5px; background: #ffc107; top: 26px; left: 41px; transform: rotate(120deg); }
        .company-logo-info .swirl-6 { width: 12px; height: 4px; background: #1976d2; top: 36px; left: 34px; transform: rotate(150deg); }
        .company-logo-info .swirl-7 { width: 18px; height: 6px; background: #00acc1; top: 41px; left: 21px; transform: rotate(180deg); }
        .company-logo-info .swirl-8 { width: 13px; height: 4px; background: #ffc107; top: 43px; left: 7px; transform: rotate(210deg); }
        .company-logo-info .swirl-9 { width: 15px; height: 5px; background: #f44336; top: 37px; left: -1px; transform: rotate(240deg); }
        .company-logo-info .swirl-10 { width: 12px; height: 4px; background: #e91e63; top: 28px; left: -3px; transform: rotate(270deg); }
        .company-logo-info .swirl-11 { width: 16px; height: 5px; background: #00bcd4; top: 19px; left: 1px; transform: rotate(300deg); }
        .company-logo-info .swirl-12 { width: 13px; height: 4px; background: #1976d2; top: 9px; left: 6px; transform: rotate(330deg); }
        
        .company-details {
            flex: 1;
        }
        
        .company-details h2 {
            color: #2c3e50;
            font-size: 1.8em;
            margin-bottom: 15px;
        }
        
        .company-details p {
            margin: 5px 0;
            font-size: 1.1em;
        }
        
        /* Alternative: If you want to use an image file instead */
        .company-logo-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            flex-shrink: 0;
        }
        
        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .invoice-meta {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 8px;
        }
        
        .invoice-meta h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.3em;
            border-bottom: 2px solid #3498db;
            padding-bottom: 5px;
        }
        
        .invoice-meta p {
            margin: 8px 0;
            font-size: 1.05em;
        }
        
        .invoice-meta strong {
            color: #2c3e50;
            display: inline-block;
            width: 120px;
        }
        
        .customer-details {
            background: #fff;
            border: 2px solid #ecf0f1;
            padding: 20px;
            border-radius: 8px;
        }
        
        .items-section {
            margin-top: 40px;
        }
        
        .items-section h3 {
            color: #2c3e50;
            font-size: 1.5em;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #3498db;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        thead {
            background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
            color: white;
        }
        
        th {
            padding: 15px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 1.1em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        tbody tr {
            background: white;
            border-bottom: 1px solid #ecf0f1;
            transition: background-color 0.3s ease;
        }
        
        tbody tr:hover {
            background: #f8f9fa;
        }
        
        tbody tr:nth-child(even) {
            background: #fdfdfd;
        }
        
        tbody tr:nth-child(even):hover {
            background: #f8f9fa;
        }
        
        td {
            padding: 12px;
            font-size: 1.05em;
            vertical-align: middle;
        }
        
        .amount-cell {
            text-align: right;
            font-weight: 600;
            color: #27ae60;
        }
        
        .total-section {
            margin-top: 30px;
            text-align: right;
        }
        
        .total-amount {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            padding: 20px 30px;
            border-radius: 8px;
            display: inline-block;
            font-size: 1.4em;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 8px;
            border-top: 3px solid #3498db;
        }
        
        .footer p {
            font-size: 1.2em;
            color: #2c3e50;
            font-style: italic;
        }
        
        .print-button {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1.1em;
            border-radius: 50px;
            cursor: pointer;
            margin-top: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }
        
        .print-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }
        
        .print-button:active {
            transform: translateY(0);
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .invoice-container {
                box-shadow: none;
                border-radius: 0;
            }
            
            .print-button {
                display: none;
            }
            
            .company-logo {
                animation: none;
            }
        }
        
        @media (max-width: 768px) {
            .invoice-details {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .invoice-content {
                padding: 20px;
            }
            
            .invoice-header {
                padding: 20px;
                flex-direction: column;
                gap: 15px;
            }
            
            .invoice-header h1 {
                font-size: 2em;
            }
            
            .company-logo {
                width: 60px;
                height: 60px;
            }
            
            .company-info {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .company-logo-info {
                width: 50px;
                height: 50px;
                align-self: center;
            }
            
            table {
                font-size: 0.9em;
            }
            
            th, td {
                padding: 8px 6px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="logo-container">
                <div class="company-logo">
                    <div class="swirl-element swirl-1"></div>
                    <div class="swirl-element swirl-2"></div>
                    <div class="swirl-element swirl-3"></div>
                    <div class="swirl-element swirl-4"></div>
                    <div class="swirl-element swirl-5"></div>
                    <div class="swirl-element swirl-6"></div>
                    <div class="swirl-element swirl-7"></div>
                    <div class="swirl-element swirl-8"></div>
                    <div class="swirl-element swirl-9"></div>
                    <div class="swirl-element swirl-10"></div>
                    <div class="swirl-element swirl-11"></div>
                    <div class="swirl-element swirl-12"></div>
                </div>
                <h1>INVOICE</h1>
            </div>
        </div>
        
        <div class="invoice-content">
            <div class="company-info">
                <!-- Option 1: Using the swirl logo design -->
                <!-- <div class="company-logo-info">
                    <div class="swirl-element swirl-1"></div>
                    <div class="swirl-element swirl-2"></div>
                    <div class="swirl-element swirl-3"></div>
                    <div class="swirl-element swirl-4"></div>
                    <div class="swirl-element swirl-5"></div>
                    <div class="swirl-element swirl-6"></div>
                    <div class="swirl-element swirl-7"></div>
                    <div class="swirl-element swirl-8"></div>
                    <div class="swirl-element swirl-9"></div>
                    <div class="swirl-element swirl-10"></div>
                    <div class="swirl-element swirl-11"></div>
                    <div class="swirl-element swirl-12"></div>
                </div> -->
                
                <!-- Option 2: Using an image file (comment out the above div and uncomment this line) -->
          <img src="images/logo.png" alt="Company Logo" class="company-logo-img">
                
                <div class="company-details">
                    <h2>CEYLON INODATA HOLDINGS PVT LTD.</h2>
                    <p><strong>📍 Address:</strong> No 413, Kalapaluwawa, Rajagiriya 11578</p>
                    <p><strong>📞 Phone:</strong> 0112685858 <strong>📞 Phone:</strong> 0112685858 <strong>📞 Phone:</strong> 0112685858</p>
                </div>
            </div>
            
            <div class="invoice-details">
                <div class="invoice-meta">
                    <h3>Invoice Details</h3>
                    <p><strong>Invoice No:</strong> <?php echo $invoice['invoice_number']; ?></p>
                    <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($invoice['created_at'])); ?></p>
                </div>
                
                <div class="customer-details">
                    <h3>Bill To</h3>
                    <p><strong>Name:</strong> <?php echo $invoice['customer_name']; ?></p>
                    <p><strong>Address:</strong> <?php echo $invoice['customer_address']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $invoice['customer_phone']; ?></p>
                </div>
            </div>
            
            <div class="items-section">
                <h3>Items & Services</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Description</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = $item_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $item['item_code']; ?></td>
                                <td><?php echo $item['item_name']; ?></td>
                                <td class="amount-cell">Rs. <?php echo number_format($item['price'], 2); ?></td>
                                <td style="text-align: center;"><?php echo $item['qty']; ?></td>
                                <td class="amount-cell">Rs. <?php echo number_format($item['total'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="total-section">
                <div class="total-amount">
                    Total Amount: Rs. <?php echo number_format($invoice['total_amount'], 2); ?>
                </div>
            </div>
            
            <div class="footer">
                <p>Thank you for your business! 🙏</p>
            </div>
            
            <center>
                <button class="print-button" onclick="window.print()">🖨️ Print Invoice</button>
            </center>
        </div>
    </div>
</body>
</html>