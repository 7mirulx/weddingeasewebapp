<!-- Email template for vendor ownership approval -->
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #f4acb7; text-align: center;">Welcome to Jom Kahwin Vendor Portal</h1>
    
    <p>Dear {{ $name }},</p>
    
    <p>Congratulations! Your vendor ownership request has been <strong>approved</strong>. Your vendor account is now active and you can start managing your listings.</p>
    
    <div style="background-color: #f5f5f5; padding: 20px; border-radius: 5px; margin: 20px 0;">
        <h3>Your Login Credentials</h3>
        <p>
            <strong>Email:</strong> {{ $email }}<br>
            <strong>Password:</strong> <code style="background: #fff; padding: 5px 10px; border-radius: 3px;">{{ $password }}</code>
        </p>
        <p><strong style="color: red;">Please save your password in a secure location.</strong></p>
    </div>
    
    <p>
        <a href="{{ url('/login') }}" style="display: inline-block; background-color: #f4acb7; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Login to Your Account
        </a>
    </p>
    
    <p>If you have any questions, please contact our support team.</p>
    
    <p>Best regards,<br>Jom Kahwin Admin Team</p>
</div>
