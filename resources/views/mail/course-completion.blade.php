@extends('mail.layout')

@section('title', 'Course Completed — ' . $course->title)

@section('content')

{{-- Hero trophy --}}
<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center" style="padding: 8px 0 20px;">
            <div style="display: inline-block; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 50%; width: 72px; height: 72px; line-height: 72px; text-align: center; font-size: 36px;">
                🏆
            </div>
        </td>
    </tr>
</table>

{{-- Headline --}}
<h2 style="font-size: 22px; font-weight: 800; color: #111827; margin: 0 0 8px; text-align: center; letter-spacing: -0.3px;">
    You did it, {{ $user->name }}!
</h2>

<p style="font-size: 15px; color: #6b7280; margin: 0 0 20px; text-align: center; line-height: 1.6;">
    You've successfully completed
</p>

{{-- Course name badge --}}
<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px;">
    <tr>
        <td align="center">
            <div style="display: inline-block; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #ffffff; font-size: 15px; font-weight: 700; padding: 10px 24px; border-radius: 100px; letter-spacing: -0.2px;">
                {{ $course->title }}
            </div>
        </td>
    </tr>
</table>

{{-- Encouragement message --}}
<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background: #f9fafb; border-radius: 12px; margin-bottom: 24px; border-left: 4px solid #4f46e5;">
    <tr>
        <td style="padding: 18px 20px;">
            <p style="font-size: 14px; color: #374151; margin: 0 0 10px; line-height: 1.75;">
                Finishing a course isn't just about watching videos — it's about showing up, staying committed, and choosing growth over comfort. That takes real discipline, and you proved you have it.
            </p>
            <p style="font-size: 14px; color: #374151; margin: 0; line-height: 1.75;">
                Every lesson you completed is a brick in the foundation of your future. Keep building. The best is yet to come. 🚀
            </p>
        </td>
    </tr>
</table>

{{-- Stats row --}}
<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px;">
    <tr>
        <td width="50%" style="padding: 0 6px 0 0;">
            <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background: #ede9fe; border-radius: 10px;">
                <tr>
                    <td style="padding: 14px; text-align: center;">
                        <div style="font-size: 24px; font-weight: 800; color: #4f46e5; line-height: 1;">{{ $course->lessons_count }}</div>
                        <div style="font-size: 11px; color: #6d28d9; font-weight: 600; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Lessons Completed</div>
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%" style="padding: 0 0 0 6px;">
            <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background: #d1fae5; border-radius: 10px;">
                <tr>
                    <td style="padding: 14px; text-align: center;">
                        <div style="font-size: 24px; font-weight: 800; color: #059669; line-height: 1;">{{ $course->formattedDuration() }}</div>
                        <div style="font-size: 11px; color: #047857; font-weight: 600; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px;">of Learning</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- CTA --}}
<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center" style="padding: 4px 0 20px;">
            <a href="{{ url('/') }}"
               style="display: inline-block; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #ffffff; text-decoration: none; font-weight: 700; padding: 14px 36px; border-radius: 8px; font-size: 14px; letter-spacing: 0.2px;">
                Explore More Courses
            </a>
        </td>
    </tr>
</table>

<p style="font-size: 12px; color: #9ca3af; margin: 0; text-align: center; line-height: 1.6;">
    Keep the momentum going — your next breakthrough is one course away.
</p>

@endsection
