<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Application Update</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f3f4f6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 40px 20px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700; letter-spacing: -0.5px;">
                                Application Update
                            </h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.9); font-size: 16px;">
                                Thank you for your interest
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

                            <!-- Main Message -->
                            <p style="margin: 0 0 25px 0; color: #4b5563; font-size: 16px; line-height: 1.7;">
                                Thank you for taking the time to apply to become a technician with Khedmaty. We appreciate your interest in joining our professional network.
                            </p>

                            <!-- Status Notice -->
                            <div style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-left: 4px solid #ef4444; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                <p style="margin: 0; color: #991b1b; font-size: 15px; line-height: 1.6;">
                                    <strong>Application Status:</strong> Unfortunately, we are unable to approve your application at this time. This decision was made after careful review of your profile and qualifications.
                                </p>
                            </div>

                            <!-- Encouragement Section -->
                            <div style="background: #e0e7ff; border-radius: 12px; padding: 25px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 15px 0; color: #4338ca; font-size: 18px; font-weight: 700;">
                                    💡 Don't Give Up!
                                </h3>
                                <p style="margin: 0 0 15px 0; color: #4b5563; font-size: 15px; line-height: 1.7;">
                                    We encourage you to continue developing your skills and experience. You're welcome to reapply in the future after:
                                </p>
                                <ul style="margin: 0; padding-left: 20px; color: #4b5563; font-size: 14px; line-height: 1.8;">
                                    <li>Gaining additional professional experience in your field</li>
                                    <li>Obtaining relevant certifications or training</li>
                                    <li>Building a stronger portfolio of completed projects</li>
                                    <li>Gathering customer testimonials and references</li>
                                </ul>
                            </div>

                            <!-- Next Steps -->
                            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 12px 0; color: #92400e; font-size: 16px; font-weight: 700;">
                                    📋 What's Next?
                                </h3>
                                <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.6;">
                                    You can submit a new application after <strong>30 days</strong> from today. We recommend using this time to strengthen your qualifications and address any areas that may need improvement.
                                </p>
                            </div>

                            <!-- Feedback Section (Optional) -->
                            @if(isset($reason) && $reason)
                            <div style="background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
                                <h3 style="margin: 0 0 12px 0; color: #1f2937; font-size: 16px; font-weight: 700;">
                                    📝 Additional Notes:
                                </h3>
                                <p style="margin: 0; color: #4b5563; font-size: 14px; line-height: 1.6;">
                                    {{ $reason }}
                                </p>
                            </div>
                            @endif

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 10px 0 30px 0;">
                                        <a href="{{ $reapplyUrl ?? '#' }}" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 10px; font-size: 16px; font-weight: 700; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);">
                                            🔄 Apply Again Later
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Support Section -->
                            <div style="border-top: 2px solid #e5e7eb; padding-top: 25px; margin-top: 10px;">
                                <p style="margin: 0 0 15px 0; color: #4b5563; font-size: 15px; line-height: 1.6;">
                                    We appreciate your understanding and thank you for your interest in Khedmaty. If you have any questions about this decision or would like guidance on improving your application, please feel free to contact us.
                                </p>
                                <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                    <strong>Contact Support:</strong> <a href="mailto:support@khedmaty.com" style="color: #667eea; text-decoration: none;">support@khedmaty.com</a>
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 15px 0; color: #1f2937; font-size: 16px; font-weight: 600;">
                                Best regards,
                            </p>
                            <p style="margin: 0 0 20px 0; color: #667eea; font-size: 18px; font-weight: 700;">
                                Khedmaty Team
                            </p>

                            <!-- Social Links -->
                            <table cellpadding="0" cellspacing="0" align="center" style="margin-bottom: 15px;">
                                <tr>
                                    <td style="padding: 0 8px;">
                                        <a href="#" style="display: inline-block; width: 36px; height: 36px; background: #6b7280; border-radius: 50%; text-align: center; line-height: 36px; color: #ffffff; text-decoration: none; font-size: 18px;">
                                            f
                                        </a>
                                    </td>
                                    <td style="padding: 0 8px;">
                                        <a href="#" style="display: inline-block; width: 36px; height: 36px; background: #6b7280; border-radius: 50%; text-align: center; line-height: 36px; color: #ffffff; text-decoration: none; font-size: 18px;">
                                            in
                                        </a>
                                    </td>
                                    <td style="padding: 0 8px;">
                                        <a href="#" style="display: inline-block; width: 36px; height: 36px; background: #6b7280; border-radius: 50%; text-align: center; line-height: 36px; color: #ffffff; text-decoration: none; font-size: 18px;">
                                            @
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Motivational Quote -->
                            <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                                <p style="margin: 0; color: #92400e; font-size: 13px; font-style: italic; line-height: 1.5;">
                                    "Success is not final, failure is not fatal: it is the courage to continue that counts."
                                </p>
                            </div>

                            <p style="margin: 0; color: #9ca3af; font-size: 12px; line-height: 1.5;">
                                © 2025 Khedmaty. All rights reserved.<br>
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
