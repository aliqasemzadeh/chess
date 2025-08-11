<div class="space-y-4">
    @if (session('message'))
        <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">
        <div class="w-full sm:w-1/2">
            <label for="game-search" class="sr-only">{{ __('Search') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input id="game-search" type="text" wire:model.debounce.500ms="search" class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Search games by player...') }}">
            </div>
        </div>
        <div class="flex justify-end">
            <button type="button" wire:click="openCreateModal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                {{ __('Add Game') }}
            </button>
        </div>
    </div>

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
