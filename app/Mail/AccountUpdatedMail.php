<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $loginUrl,
        public ?string $className
    ) {
    }

    public function build(): self
    {
        return $this->subject('Your account details were updated')
            ->view('emails.account-updated');
    }
}
