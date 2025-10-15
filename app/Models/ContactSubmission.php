<?php

namespace App\Models;

use App\Mail\ContactSubmitted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Resend\Laravel\Facades\Resend;

class ContactSubmission extends Model
{
    /** @use HasFactory<\Database\Factories\ContactSubmissionFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','email','subject','message','attachment','ip', 'ua', 'hash',
    ];

    protected static function booted(): void
    {
        static::created(function (ContactSubmission $submission) {
            if (env('QUEUE_MAIL', false) === true) {
                Mail::to(env('NOTIFY_ADDRESS'))
                    ->queue(new ContactSubmitted($submission));
            } else {
                Mail::to(env('NOTIFY_ADDRESS'))
                    ->send(new ContactSubmitted($submission))
                    ->afterCommit();
            }
        });
    }
}
