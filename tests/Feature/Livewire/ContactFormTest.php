<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders()
    {
        Livewire::test(\App\Livewire\ContactForm::class)
            ->assertStatus(200)
            ->assertSee('Contact');
    }

    public function test_validates_and_submits()
    {
        Mail::fake();

        Livewire::test(\App\Livewire\ContactForm::class)
            ->set('name','Ada')
            ->set('email','ada@example.com')
            ->set('subject','Hi')
            ->set('message','Hello')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSee('Thanks! Your message has been sent.');

        $this->assertDatabaseHas('contact_submissions', [
            'email' => 'ada@example.com', 'subject' => 'Hi',
        ]);
    }

    public function test_contact_form_shows_errors()
    {
        Livewire::test(\App\Livewire\ContactForm::class)
            ->set('email', 'not-an-email')
            ->call('submit')
            ->assertHasErrors(['email' => 'email']);
    }
}
