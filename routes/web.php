<?php

use App\Livewire\ContactSubmissionList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.contact');
})->name('contact.form');

Route::get('/admin/messages', function () {
    return view('pages.admin');
})->name('admin.messages.index');