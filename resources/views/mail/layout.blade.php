<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Career 180')</title>
    <!--[if mso]>
    <style type="text/css">
        body, table, td {font-family: Arial, sans-serif !important;}
    </style>
    <![endif]-->
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #1f2937; background-color: #f3f4f6;">
    <!--[if mso]>
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td align="center" style="padding: 20px;">
    <![endif]-->
    
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 480px; margin: 0 auto; background-color: #ffffff; width: 100%;">
        <!-- Header -->
        <tr>
            <td style="padding: 24px 16px; text-align: center; background-color: #4f46e5;">
                <h1 style="font-size: 22px; font-weight: 800; color: #ffffff; margin: 0;">
                    Career<span style="color: #c7d2fe;">180</span>
                </h1>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 24px 16px;">
                @yield('content')
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="padding: 16px; text-align: center; border-top: 1px solid #e5e7eb;">
                <p style="font-size: 11px; color: #9ca3af; margin: 0;">
                    &copy; {{ date('Y') }} Career 180. All rights reserved.
                </p>
            </td>
        </tr>
    </table>

    <!--[if mso]>
    </td>
    </tr>
    </table>
    <![endif]-->
</body>
</html>
