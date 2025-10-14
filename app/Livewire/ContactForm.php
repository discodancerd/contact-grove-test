<?php

namespace App\Livewire;

use App\Models\ContactSubmission;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContactForm extends Component
{
    use WithFileUploads;

    public $title = 'Contact Form';

    #[Validate('required|string|min:2|max:255')]  public string $name = '';
    #[Validate('required|email|max:255')]         public string $email = '';
    #[Validate('required|string|min:2|max:255')]  public string $subject = '';
    #[Validate('required|string|min:5|max:2048')] public string $message = '';

    // Attachment is optional, 1 MB limit, allow image types
    #[Validate('nullable|file|max:1024|mimes:jpg,jpeg,png,webp')]
    public $attachment;

    public function submit(Request $request)
    {
        $this->validate();

        if (RateLimiter::tooManyAttempts('send-message:'.$request->ip(), $perMinute = 10)) {
            session()->flash('warning', 'Too many attempts. Please wait before continuing.');
            return;
        }

        $filename = null;

        if ($this->attachment) {
            $ext        = $this->attachment->getClientOriginalExtension();
            $safeName   = Str::uuid();
            $filename   = $safeName . '.' . $ext;

            // store in storage/app/contact-attachments
            $storedPath = $this->attachment->storeAs('contact-attachments', $filename);
        }

        // Duplicate prevention
        $canonEmail   = mb_strtolower(trim($this->email));
        $canonSubject = preg_replace('/\s+/u',' ', trim($this->subject));
        $canonMessage = preg_replace("/\s+/u", '', trim($this->message));

        $hash = hash('sha256', $canonEmail.$canonSubject.$canonMessage);

        try {
            ContactSubmission::create([
                'name'       => $this->name,
                'email'      => $this->email,
                'subject'    => $this->subject,
                'message'    => $this->message,
                'attachment' => $filename,
                'ip'         => $request->ip(),
                'ua'         => $request->userAgent(),
                'hash'       => $hash,
            ]);
        } catch (QueryException $e) {
            // SQL duplicate key error code
            if ($e->getCode() === '23000') {
                session()->flash('warning', 'The message is already sent.');
            }
            return;
        }

        RateLimiter::increment('send-message:'.$request->ip());

        // Queue notification job or put on model create

        // Reset form (keep no attachment)
        $this->reset(['name','email','subject','message','attachment']);

        // Flash UI feedback
        session()->flash('contact_ok', 'Thanks! Your message has been sent.');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
