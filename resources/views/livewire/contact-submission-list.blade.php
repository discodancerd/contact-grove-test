<div class="space-y-4">
  {{-- Filters --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
    <div>
      <label class="block text-sm font-medium">Search by Email
      <input type="text"
             wire:model.live.debounce.500ms="email"
             class="mt-1 w-full rounded border p-2"
             placeholder="user@example.com"></label>
    </div>
    <div>
      <label class="block text-sm font-medium">Search by Subject
      <input type="text"
             wire:model.live.debounce.500ms="subject"
             class="mt-1 w-full rounded border p-2"
             placeholder="Subject…"></label>
    </div>
    <div>
      <label class="block text-sm font-medium">Per Page
      <select wire:model.live="perPage" class="mt-1 w-full rounded border p-2">
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="25">25</option>
        <option value="50">50</option>
      </select></label>
    </div>
  </div>

  {{-- Table --}}
  <div class="overflow-x-auto rounded border">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50 text-black">
        <tr class="text-left">
          <th class="px-3 py-2">Name</th>
          <th class="px-3 py-2">Email</th>
          <th class="px-3 py-2">Subject</th>
          <th class="px-3 py-2">Message</th>
          <th class="px-3 py-2">Created</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse($submissions as $s)
          <tr>
            <td class="px-3 py-2">{{ $s->name }}</td>
            <td class="px-3 py-2">{{ $s->email }}</td>
            <td class="px-3 py-2">
              <div class="line-clamp-2">{{ $s->subject }}</div>
            </td>
            <td class="px-3 py-2">
              <div class="line-clamp-2">{{ $s->message }}</div>
            </td>
            <td class="px-3 py-2 whitespace-nowrap">
              {{ $s->created_at->format('Y-m-d H:i') }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-3 py-6 text-center text-gray-500">
              No messages found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  <div class="cursor-pointer">
    {{ $submissions->onEachSide(1)->links() }}
  </div>
</div>
