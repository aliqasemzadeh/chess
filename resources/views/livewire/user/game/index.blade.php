<div class="space-y-4">
    @if (session('message'))
        <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">{{ __('White') }}</th>
                <th scope="col" class="px-6 py-3">{{ __('Black') }}</th>
                <th scope="col" class="px-6 py-3">{{ __('Turn') }}</th>
                <th scope="col" class="px-6 py-3">{{ __('FEN') }}</th>
                <th scope="col" class="px-6 py-3">{{ __('Created At') }}</th>
                <th scope="col" class="px-6 py-3">{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($games as $game)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $game->id }}</td>
                    <td class="px-6 py-4">{{ $game->white?->name ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $game->black?->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-medium" :class="{}">
                            {{ $game->turn_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4"><code class="text-xs">{{ \Illuminate\Support\Str::limit($game->fen, 40) }}</code></td>
                    <td class="px-6 py-4">{{ $game->created_at?->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4 space-x-2 rtl:space-x-reverse">
                        <button type="button" wire:click="openEditModal({{ $game->id }})" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('Edit') }}</button>
                        <button type="button" onclick="if(confirm('{{ __('Are you sure?') }}')) { Livewire.dispatch('call', { component: @this.__instance.id, method: 'delete', params: [{{ $game->id }}] }); }" class="font-medium text-red-600 dark:text-red-500 hover:underline">{{ __('Delete') }}</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center">{{ __('No results found.') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $games->links() }}
    </div>
</div>
