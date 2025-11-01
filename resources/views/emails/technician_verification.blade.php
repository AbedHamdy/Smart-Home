<x-mail::message>
# 🔐 Verify Your Technician Account

Hello **{{ $technicianName }}**,

Thank you for registering as a technician with us! We're excited to have you on board.

To complete your registration and activate your account, please use the verification code below:

<x-mail::panel>
## Your Verification Code

<div style="font-size: 36px; font-weight: bold; color: #667eea; letter-spacing: 8px; text-align: center; padding: 20px 0;">
{{ $verificationCode }}
</div>
</x-mail::panel>

**Important Notes:**
- This code will expire in **30 minutes** for security reasons
- Do not share this code with anyone
- If you didn't request this code, please ignore this email

<x-mail::button :url="route('technician.verification')" color="primary">
Enter Verification Code
</x-mail::button>

Need help? Contact our support team at support@khedmaty.com

Thanks,<br>
**{{ config('app.name') }} Team** 🏠
</x-mail::message>
