<?php

namespace App\Mail;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $member;
    public $resetUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
        // メールアドレスのみを渡すシンプルなURL
        $this->resetUrl = route('member.password.reset.form', ['email' => $member->email]);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('パスワード再設定のお知らせ')
                    ->view('emails.password_reset');
    }
}