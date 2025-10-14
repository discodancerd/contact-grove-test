<?php

namespace Database\Seeders;

use App\Models\ContactSubmission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactSubmission::factory()->count(30)->create();
    }
}
