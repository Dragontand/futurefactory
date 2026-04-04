<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Modules
        </x-header-title>

        <x-secondary-button href="{{ route('modules.create') }}" class="flex-end">
            Create
        </x-secondary-button>
    </x-slot>
    
    <div class="space-y-4">
        @foreach ($modules as $module)
            <a href="{{ route('modules.show', $module) }}" class="block px-4 py-6 border border-gray-600 rounded-lg">
                <div class="font-bold text-blue-500 text-xl">{{ ucfirst($module->name) }}</div>
                <div class="flex justify-between">
                    <div class="flex flex-col">
                        <div>
                            <x-span-tag :value="__('Type:')" />
                            {{ $module->getTypeLabel() }}
                        </div>
                        <div>
                            <x-span-tag :value="__('Price:')" />
                            ${{ $module->price }}
                        </div>
                        <div>
                            <x-span-tag :value="__('Time:')" />
                            {{ $module->time }}
                        </div>
                    </div>
                    <img src="{{ $module->image }}" alt="" class="max-w-[150px] max-h-[100px] rounded-lg overflow-hidden">
                </div>
            </a>
        @endforeach
        <div>
            {{ $modules->links(); }}
        </div>
    </div>
</x-app-layout>

