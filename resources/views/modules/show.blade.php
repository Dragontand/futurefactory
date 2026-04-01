<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Module
        </x-header-title>

        <x-secondary-button href="{{ route('modules.create') }}" class="flex-end">
            Create
        </x-secondary-button>
    </x-slot>
    <div class="space-y-4">
        <div class="font-bold text-blue-500 text-xl">{{ ucfirst($module->name) }}</div>
        <div class="flex justify-between">
            <div class="flex flex-col">
                <div><strong>Type: </strong>{{ $module->getTypeLabel() }}</div>
                <div><strong>Price: $</strong>{{ $module->price }}</div>
                <div><strong>Time: </strong>{{ $module->time }}</div>
            </div>
            <img src="{{ $module->image }}" alt="" class="max-w-[150px] max-h-[100px]">
        </div>
        <x-secondary-button href="{{ route('modules.edit', $module) }}">
            Edit
        </x-secondary-button>
    </div>
</x-app-layout>