<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9fafb;
        }
        .email-content {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            border-left: 4px solid #ec4899;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #be123c;
        }
        h1 {
            color: #1f2937;
            margin-bottom: 10px;
        }
        .intro {
            color: #6b7280;
            margin-bottom: 20px;
        }
        .business-info {
            background-color: #f3f4f6;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .business-info p {
            margin: 8px 0;
        }
        .info-label {
            font-weight: bold;
            color: #374151;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 6px;
            font-weight: bold;
            margin: 25px 0;
            text-align: center;
        }
        .cta-button:hover {
            background: linear-gradient(135deg, #e11d48 0%, #db2777 100%);
        }
        .steps {
            background-color: #f9fafb;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .step {
            display: flex;
            margin-bottom: 12px;
            align-items: flex-start;
        }
        .step-number {
            background-color: #ec4899;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 12px;
            flex-shrink: 0;
        }
        .step-text {
            flex: 1;
            padding-top: 4px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 13px;
        }
        .expiry-warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px 15px;
            border-radius: 4px;
            margin: 20px 0;
            color: #92400e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-content">
            {{-- Header --}}
            <div class="header">
                <div class="logo">💍 Jom Kahwin</div>
            </div>

            {{-- Greeting --}}
            <h1>Claim Your Vendor Business</h1>
            <p class="intro">Hello,</p>
            
            <p>Congratulations! Your wedding vendor business is listed on Jom Kahwin. To start managing your bookings and connect with clients, please create a vendor account and claim your business.</p>

            {{-- Business Preview --}}
            <div class="business-info">
                <p><span class="info-label">📌 Business Name:</span> {{ $vendor->vendor_name }}</p>
                <p><span class="info-label">🎯 Category:</span> {{ $vendor->category ?? 'Not specified' }}</p>
                <p><span class="info-label">📍 Location:</span> {{ $vendor->city ?? 'N/A' }}, {{ $vendor->state ?? 'N/A' }}</p>
                <p><span class="info-label">💰 Starting Price:</span> RM{{ number_format($vendor->starting_price ?? 0, 2) }}</p>
                <p><span class="info-label">📧 Email:</span> {{ $vendor->email }}</p>
                <p><span class="info-label">📱 Phone:</span> {{ $vendor->phone ?? 'Not provided' }}</p>
            </div>

            {{-- CTA Button --}}
            <p style="text-align: center;">
                <a href="{{ $claimUrl }}" class="cta-button">Claim Your Business Now</a>
            </p>

            {{-- How It Works --}}
            <p style="font-weight: bold; color: #1f2937; margin-top: 25px;">How to claim your business:</p>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-text">Click the "Claim Your Business Now" button above</div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-text">Create a new vendor account with your information</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-text">Verify the business information and complete payment</div>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-text">Your account is activated and ready to manage bookings</div>
                </div>
            </div>

            {{-- Expiry Warning --}}
            <div class="expiry-warning">
                <strong>Important:</strong> This claim link expires on {{ $expiresAt->format('F d, Y') }} at {{ $expiresAt->format('g:i A') }}. Please claim your business before this date.
            </div>

            {{-- Benefits --}}
            <p style="font-weight: bold; color: #1f2937;">Once claimed, you'll be able to:</p>
            <ul style="color: #6b7280;">
                <li>Manage all your wedding bookings in one place</li>
                <li>View client ratings and reviews</li>
                <li>Update your pricing and availability</li>
                <li>Increase your visibility on Jom Kahwin</li>
                <li>Track your business performance</li>
            </ul>

            {{-- Direct Link --}}
            <p style="background-color: #f3f4f6; padding: 12px; border-radius: 4px; word-break: break-all; font-size: 12px;">
                <strong>Direct Link:</strong><br>
                {{ $claimUrl }}
            </p>

            {{-- Footer --}}
            <div class="footer">
                <p>If you did not request this email or have any questions, please contact our support team at support@jomkahwin.com</p>
                <p style="margin-top: 10px;">This is an automated email. Please do not reply directly to this message.</p>
                <p style="margin-top: 20px; border-top: 1px solid #e5e7eb; padding-top: 15px;">
                    &copy; 2025 Jom Kahwin. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
