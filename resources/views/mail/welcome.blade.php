@extends('mail.layout')

@section('title', 'Welcome to Career 180')

@section('content')
<h2 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 10px; text-align: center;">
    Welcome, {{ $user->name }}! 👋
</h2>

<p style="font-size: 14px; color: #4b5563; margin: 0 0 14px; text-align: center;">
    Thank you for joining Career 180! We're excited to help you accelerate your developer career with our expert-led courses.
</p>

<!-- Features Box -->
<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background: #f9fafb; border-radius: 8px; margin: 16px 0;">
    <tr>
        <td style="padding: 16px;">
            <h3 style="font-size: 13px; font-weight: 600; color: #111827; margin: 0 0 10px;">
                Here's what you can do next:
            </h3>
            <p style="font-size: 13px; color: #4b5563; margin: 0; line-height: 1.8;">
                ✓ Browse our course catalog<br>
                ✓ Enroll in your first course<br>
                ✓ Start learning at your own pace
            </p>
        </td>
    </tr>
</table>

<!-- CTA Button -->
<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center" style="padding: 14px 0;">
            <a href="{{ url('/') }}" style="display: inline-block; background: #4f46e5; color: #ffffff; text-decoration: none; font-weight: 600; padding: 12px 28px; border-radius: 6px; font-size: 14px; width: 100%; max-width: 200px; box-sizing: border-box;">
                Explore Courses
            </a>
        </td>
    </tr>
</table>

<p style="font-size: 12px; color: #6b7280; margin: 16px 0 0; text-align: center;">
    If you have any questions, feel free to reply to this email. We're here to help!
</p>
@endsection
