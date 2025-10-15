<?php

namespace Tests\Feature\Livewire;

use App\Models\ContactSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactSubmissionListTest extends TestCase
{
    use RefreshDatabase;

    public function test_table_filters_by_email_and_subject()
    {
        Mail::fake();

        \App\Models\ContactSubmission::factory()->create([
            'email' => 'alice@example.com', 'subject' => 'Welcome',
        ]);
        \App\Models\ContactSubmission::factory()->create([
            'email' => 'bob@example.com', 'subject' => 'Invoice',
        ]);

        Livewire::test(\App\Livewire\ContactSubmissionList::class)
            ->set('email', 'alice')
            ->assertSee('alice@example.com')
            ->assertDontSee('bob@example.com')
            ->set('email', '')
            ->set('subject', 'Invoice')
            ->assertSee('Invoice')
            ->assertDontSee('Welcome');

        Mail::assertNothingSent();
    }

    public function test_per_page_changes_results()
    {
        Mail::fake();

        \App\Models\ContactSubmission::factory()->count(30)->create();

        Livewire::test(\App\Livewire\ContactSubmissionList::class)
            ->set('perPage', 10)
            ->assertViewHas('submissions', fn ($p) => $p->count() === 10)
            ->set('perPage', 25)
            ->assertViewHas('submissions', fn ($p) => $p->count() === 25);

        Mail::assertNothingSent();
    }
}
