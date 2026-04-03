<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Schedule — {{ $date }}
        </x-header-title>

        <x-secondary-button href="{{ route('schedules.index') }}">
            Back
        </x-secondary-button>
    </x-slot>

    <div class="space-y-4">
        @foreach ($slots as $slot)
            <div class="px-4 py-6 border border-gray-600 rounded-lg flex justify-between items-center">
                <div>
                    <div class="font-bold text-blue-500 text-xl">
                        Slot {{ $slot['number'] }} — {{ $slot['label'] }}
                    </div>

                    @if ($slot['schedule'])
                        <div class="mt-2">
                            <div>
                                <x-span-tag :value="__('Type:')" />
                                {{ ucfirst($slot['schedule']['type']) }}
                            </div>
                            <div>
                                <x-span-tag :value="__('Robot:')" />
                                {{ $slot['schedule']['robot'] }}
                            </div>
                            @if ($slot['schedule']['vehicle'])
                                <div>
                                    <x-span-tag :value="__('Vehicle:')" />
                                    {{ $slot['schedule']['vehicle'] }}
                                </div>
                            @endif
                            <div>
                                <x-span-tag :value="__('Status:')" />
                                {{ $slot['schedule']['is_complete'] ? 'Complete' : 'In progress' }}
                            </div>
                        </div>
                    @else
                        <p class="mt-2 text-gray-400">Available</p>
                    @endif
                </div>

                @if ($slot['isAvailable'])
                    <x-secondary-button href="{{ route('schedules.create', ['day' => $date, 'slot' => $slot['number']]) }}">
                        Schedule
                    </x-secondary-button>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>
