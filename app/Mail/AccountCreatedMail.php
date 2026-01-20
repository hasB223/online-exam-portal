<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $setPasswordUrl,
        public string $loginUrl,
        public ?string $className
    ) {
    }

    public function build(): self
    {
        return $this->subject('Your account was created')
            ->view('emails.account-created');
    }
}
