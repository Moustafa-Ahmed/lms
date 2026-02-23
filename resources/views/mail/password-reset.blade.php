@extends('mail.layout')

@section('title', 'Reset Your Password')

@section('content')
<h2 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 10px; text-align: center;">
    Reset Your Password
</h2>

<p style="font-size: 14px; color: #4b5563; margin: 0 0 14px; text-align: center;">
    Hi {{ $user->name }}, we received a request to reset your password.
</p>

<!-- CTA Button -->
<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center" style="padding: 14px 0;">
            <a href="{{ $url }}" style="display: inline-block; background: #4f46e5; color: #ffffff; text-decoration: none; font-weight: 600; padding: 12px 28px; border-radius: 6px; font-size: 14px; width: 100%; max-width: 200px; box-sizing: border-box;">
                Reset Password
            </a>
        </td>
    </tr>
</table>

<p style="font-size: 13px; color: #6b7280; margin: 16px 0 0; text-align: center;">
    This link will expire in 60 minutes.
</p>

<p style="font-size: 12px; color: #9ca3af; margin: 20px 0 0; text-align: center;">
    If you didn't request a password reset, you can safely ignore this email.
</p>
@endsection
