<?php

namespace App\Livewire;

use App\Models\ContactSubmission;
use Livewire\Component;
use Livewire\WithPagination;

class ContactSubmissionList extends Component
{
    use WithPagination;

    protected string $pageName = 'submissionsList';
    public string $email = '';
    public string $subject = '';
    public int $perPage = 15;

    // keep filters/pagination in the URL; reset page when filters change
    protected $queryString = [
        'email'   => ['except' => ''],
        'subject' => ['except' => ''],
        'perPage' => ['except' => 15],
        'submissionsList' => ['except' => 1, 'as' => 'page'],
    ];

    public function updatingEmail()   { $this->resetPage($this->pageName); }
    public function updatingSubject() { $this->resetPage($this->pageName); }
    public function updatedPerPage($v)
    {
        $this->perPage = (int) $v;
        $this->resetPage($this->pageName); 
    }

    public function render()
    {
        $submissions = ContactSubmission::query()
            ->when($this->email !== '', fn($q) =>
                $q->where('email', 'like', '%'.trim($this->email).'%')
            )
            ->when($this->subject !== '', fn($q) =>
                $q->where('subject', 'like', '%'.trim($this->subject).'%')
            )
            ->orderByDesc('created_at')
            ->paginate($this->perPage, pageName: $this->pageName);

        return view('livewire.contact-submission-list', [
            'submissions' => $submissions,
        ]);
    }
}
