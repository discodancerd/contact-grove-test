<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="px-8">
        <div class="w-full h-16 flex flex-row mx-auto items-center">
            <a href="{{ route('contact.form') }}"
               @class([
                 'px-3 py-2 rounded',
                 request()->routeIs('contact.form') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100'
               ])
               @if (class_exists(\Livewire\Mechanisms\Navigate\Navigate::class)) wire:navigate @endif
            >Contact Form</a>

            <a href="{{ route('admin.messages.index') }}"
               @class([
                 'px-3 py-2 rounded',
                 request()->routeIs('admin.messages.index') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100'
               ])
               @if (class_exists(\Livewire\Mechanisms\Navigate\Navigate::class)) wire:navigate @endif
            >Messages</a>
        </div>
        {{ $slot ?? '' }}
        @livewireScripts
        @livewireScriptConfig(['navigate' => true])
    </body>
</html>
