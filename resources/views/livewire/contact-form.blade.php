<div class="p-4">
    <div class="max-w-xl mx-auto">
        <p class="text-4xl my-8">{{ $title }}</p>
        @if (session('contact_ok'))
            <div class="mb-4 rounded bg-green-100 p-3 text-green-800">
                {{ session('contact_ok') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="mb-4 rounded bg-yellow-100 p-3 text-yellow-800">
                {{ session('warning') }}
            </div>
        @endif

        <form wire:submit.prevent="submit" class="space-y-4" enctype="multipart/form-data">
            @csrf
            <div class="invisible" aria-hidden="true" tabindex="-1">
                <label for="company">Company</label>
                <input id="company"
                       name="company"
                       type="text"
                       wire:model.defer="hp"
                       autocomplete="off"
                       tabindex="-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Name
                <input type="text" wire:model.live="name" class="mt-1 w-full rounded border p-2"></label>
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Email
                <input type="email" wire:model.live="email" class="mt-1 w-full rounded border p-2"></label>
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Subject
                <input type="text" wire:model.live="subject" class="mt-1 w-full rounded border p-2"></label>
                @error('subject') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Message
                <textarea rows="6" wire:model.live="message" class="mt-1 w-full rounded border p-2"></textarea></label>
                @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Attachment (optional)
                <input type="file" wire:model="attachment" class="mt-1 w-full rounded border p-2"></label>
                @error('attachment') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                <div x-data="{ isUploading: false, progress: 0 }"
                     x-on:livewire-upload-start="isUploading = true"
                     x-on:livewire-upload-finish="isUploading = false; progress = 0"
                     x-on:livewire-upload-error="isUploading = false"
                     x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <div x-show="isUploading" class="mt-2">
                        <div class="h-2 w-full rounded bg-gray-200">
                            <div class="h-2 rounded bg-blue-500" :style="`width: ${progress}%;`"></div>
                        </div>
                        <p class="text-xs text-gray-600 mt-1" x-text="progress + '%'"></p>
                    </div>
                </div>
            </div>

            <button wire:click.prevent="submit" wire:loading.attr="disabled" class="rounded bg-black px-4 py-2 text-white cursor-pointer">Send</button>
        </form>
    </div>
</div>
