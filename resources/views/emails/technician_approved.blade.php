<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Account Approved</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f3f4f6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 40px 20px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">

                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: -0.5px;">
                                🎉 Account Approved!
                            </h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 16px;">
                                Welcome to Smart Home Team
                            </p>
                        </td>
                    </tr>

                    <!-- Content Section -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <!-- Greeting -->
                            <h2 style="margin: 0 0 20px 0; color: #1f2937; font-size: 22px; font-weight: 600;">
                                Hello {{ $name }},
                            </h2>

                            <!-- Success Message -->
                            <div style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-left: 4px solid #10b981; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                <p style="margin: 0; color: #065f46; font-size: 16px; line-height: 1.6;">
                                    <strong>Congratulations!</strong> Your technician account has been successfully approved. You're now part of our trusted professional network.
                                </p>
                            </div>

                            <!-- Main Content -->
                            <p style="margin: 0 0 25px 0; color: #4b5563; font-size: 15px; line-height: 1.7;">
                                You can now access your account and start providing your expert services to our customers. Below are your login credentials:
                            </p>

                            <!-- Credentials Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; overflow: hidden; margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            {{-- <tr>
                                                <td style="padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="color: #6b7280; font-size: 14px; font-weight: 600;">
                                                                📧 Email
                                                            </td>
                                                            <td align="right" style="color: #1f2937; font-size: 15px; font-weight: 500;">
                                                                {{ $email }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td style="padding: 12px 0;">
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="color: #6b7280; font-size: 14px; font-weight: 600;">
                                                                🔑 Password
                                                            </td>
                                                            <td align="right" style="color: #1f2937; font-size: 15px; font-weight: 700; font-family: 'Courier New', monospace; background: #fef3c7; padding: 4px 8px; border-radius: 4px;">
                                                                {{ $password }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Warning -->
                            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 16px; border-radius: 8px; margin-bottom: 30px;">
                                <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.6;">
                                    <strong>⚠️ Important:</strong> For security reasons, please change your password immediately after your first login.
                                </p>
                            </div>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 10px 0 30px 0;">
                                        <a href="{{ route("login") }}" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 10px; font-size: 16px; font-weight: 700; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4); transition: all 0.3s ease;">
                                            🚀 Login to Your Account
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Next Steps -->
                            <div style="background: #e0e7ff; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
                                <h3 style="margin: 0 0 15px 0; color: #4338ca; font-size: 16px; font-weight: 700;">
                                    📋 Next Steps:
                                </h3>
                                <ul style="margin: 0; padding-left: 20px; color: #4b5563; font-size: 14px; line-height: 1.8;">
                                    <li>Log in to your account using the credentials above</li>
                                    <li>Complete your profile with additional details</li>
                                    <li>Review and accept our terms of service</li>
                                    <li>Start accepting service requests from customers</li>
                                </ul>
                            </div>

                            <!-- Support Section -->
                            <p style="margin: 0 0 10px 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                If you have any questions or need assistance, please don't hesitate to contact our support team.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 15px 0; color: #1f2937; font-size: 16px; font-weight: 600;">
                                Best regards,
                            </p>
                            <p style="margin: 0 0 20px 0; color: #667eea; font-size: 18px; font-weight: 700;">
                                Smart Home Team
                            </p>

                            <!-- Social Links -->
                            <table cellpadding="0" cellspacing="0" align="center" style="margin-bottom: 15px;">
                                <tr>
                                    <td style="padding: 0 8px;">
                                        <a href="#" style="display: inline-block; width: 36px; height: 36px; background: #667eea; border-radius: 50%; text-align: center; line-height: 36px; color: #ffffff; text-decoration: none; font-size: 18px;">
                                            f
                                        </a>
                                    </td>
                                    <td style="padding: 0 8px;">
                                        <a href="#" style="display: inline-block; width: 36px; height: 36px; background: #667eea; border-radius: 50%; text-align: center; line-height: 36px; color: #ffffff; text-decoration: none; font-size: 18px;">
                                            in
                                        </a>
                                    </td>
                                    <td style="padding: 0 8px;">
                                        <a href="#" style="display: inline-block; width: 36px; height: 36px; background: #667eea; border-radius: 50%; text-align: center; line-height: 36px; color: #ffffff; text-decoration: none; font-size: 18px;">
                                            @
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0; color: #9ca3af; font-size: 12px; line-height: 1.5;">
                                © 2025 Smart Home. All rights reserved.<br>
                                This is an automated message, please do not reply to this email.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
