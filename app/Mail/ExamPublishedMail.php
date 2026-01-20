<?php

namespace App\Mail;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExamPublishedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Exam $exam,
        public User $student,
        public string $examsUrl
    ) {
    }

    public function build(): self
    {
        return $this->subject('New exam published: '.$this->exam->title)
            ->view('emails.exam-published');
    }
}
