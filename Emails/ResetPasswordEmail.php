<?php

namespace Modules\User\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Entities\UserInterface;

class ResetPasswordEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var UserInterface
     */
    public $user;

    public $code;

    public function __construct(UserInterface $user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        return $this->view('user::emails.reminder')
            ->subject(trans('user::messages.reset password'));
    }
}
