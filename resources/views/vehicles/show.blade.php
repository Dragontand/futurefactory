<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Vehicles: {{ $vehicle->name }}
        </x-header-title>

        <x-secondary-button href="{{ route('vehicles.create') }}" class="flex-end">
            Create
        </x-secondary-button>
    </x-slot>

    <h3 class="text-lg font-semibold text-gray-300 mb-4">Assembly order</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        @foreach ($assemblyOrder as $module)
            <a href="{{ route('modules.show', $module['moduleType']) }}" class="block border border-gray-600 rounded-lg overflow-hidden hover:border-blue-500 transition-colors">
                <img src="{{ $module['moduleType']->image }}" alt="{{ $module['moduleType']->name }}" class="w-full h-32 object-cover" />
                <div class="p-3">
                    <div class="text-xs text-gray-400">{{ $module['label'] }}</div>
                    <div class="font-semibold text-blue-400">{{ $module['moduleType']->name }}</div>
                    <div class="text-sm text-gray-300">${{ number_format($module['moduleType']->price, 2) }}</div>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-6">
        <x-span-tag class="text-emerald-400" :value="__('Total:')" />
        <span class="text-lg font-bold">${{ number_format($vehicle->calcTotal(), 2) }}</span>
    </div>

    <form method="POST" action="{{ route('vehicles.destroy', $vehicle) }}" class="mt-4">
        @csrf
        @method('DELETE')
        <x-primary-button :color="'bg-rose-800 dark:bg-rose-600 hover:bg-rose-700 dark:hover:bg-rose-500 focus:bg-rose-700 dark:focus:bg-rose-500 active:bg-rose-900 dark:active:bg-rose-700'">
            Delete
        </x-primary-button>
    </form>
</x-app-layout>