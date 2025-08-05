<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Due - Digital Ascent BD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4f46e5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .invoice-details {
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #4f46e5;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Digital Ascent BD</h1>
        <p>Google Workspace Reseller</p>
    </div>
    
    <div class="content">
        <h2>Payment Reminder</h2>
        
        <p>Dear {{ $company->name }},</p>
        
        <p>This is a friendly reminder that your payment for Google Workspace services is due.</p>
        
        <div class="invoice-details">
            <h3>Invoice Details</h3>
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Amount Due:</strong> ৳{{ number_format($invoice->amount) }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date->format('F d, Y') }}</p>
            <p><strong>Plan:</strong> {{ $plan->name }}</p>
            <p><strong>Billing Cycle:</strong> {{ ucfirst($subscription->billing_cycle) }}</p>
        </div>
        
        <p>To ensure uninterrupted service, please make your payment as soon as possible.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('payment.process', $invoice) }}" class="button">
                Pay Now
            </a>
        </div>
        
        <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
        
        <div class="footer">
            <p><strong>Digital Ascent BD</strong></p>
            <p>Dhaka, Bangladesh</p>
            <p>Email: support@digitalascentbd.com</p>
            <p>Phone: +880 XXXX-XXXXXX</p>
            <p>© 2024 Digital Ascent BD. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 