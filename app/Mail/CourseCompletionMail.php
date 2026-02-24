<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class CourseCompletionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Course $course,
    ) {}

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [
            (new WithoutOverlapping("course-completion-mail:{$this->user->getKey()}:{$this->course->getKey()}"))
                ->shared()
                ->expireAfter(300),
        ];
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "You completed \"{$this->course->title}\" — well done!",
            from: new Address('hello@example.com', 'Career 180'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.course-completion',
        );
    }
}
