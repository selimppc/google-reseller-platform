<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-info {
            margin-bottom: 30px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .invoice-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Digital Ascent BD</h1>
        <p>Google Workspace Reseller</p>
        <p>Dhaka, Bangladesh</p>
    </div>

    <div class="company-info">
        <h3>Bill To:</h3>
        <p><strong>{{ $invoice->company->name }}</strong></p>
        <p>{{ $invoice->company->billing_address }}</p>
        <p>Phone: {{ $invoice->company->contact_phone }}</p>
    </div>

    <div class="invoice-details">
        <table style="width: 100%;">
            <tr>
                <td><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</td>
                <td><strong>Date:</strong> {{ $invoice->created_at->format('M d, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</td>
                <td><strong>Status:</strong> {{ ucfirst($invoice->status) }}</td>
            </tr>
        </table>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Period</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->subscription->plan->name }} - Google Workspace</td>
                <td>{{ $invoice->subscription->billing_cycle === 'monthly' ? 'Monthly' : 'Annual' }}</td>
                <td>BDT {{ number_format($invoice->amount) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="2" style="text-align: right;"><strong>Total:</strong></td>
                <td><strong>BDT {{ number_format($invoice->amount) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Thank you for choosing Digital Ascent BD for your Google Workspace needs.</p>
        <p>For support, contact us at support@digitalascentbd.com</p>
        <p>© 2024 Digital Ascent BD. All rights reserved.</p>
    </div>
</body>
</html> 