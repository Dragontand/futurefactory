<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Schedule — {{ $date }}
        </x-header-title>

        <x-secondary-button href="{{ route('schedules.index') }}">
            Back
        </x-secondary-button>
    </x-slot>

    <!-- Slots  -->
    <div class="space-y-4">
        @foreach ($slots as $slot)
            <div class="px-4 py-6 border border-gray-600 rounded-lg flex justify-between items-start">
                <div class="flex-1">
                    <div class="font-bold text-blue-500 text-xl">
                        Slot {{ $slot['number'] }} — {{ $slot['label'] }}
                    </div>

                    @if (count($slot['schedules']) > 0)
                        <div class="mt-2 space-y-3">
                            @foreach ($slot['schedules'] as $schedule)
                                @if ($schedule['type'] === 'assembly')
                                    <div class="p-3 bg-gray-800 border-l-4 border-blue-500 rounded-md flex items-center gap-6">
                                        <div>
                                            <x-span-tag :value="__('Type:')" />
                                            Assembly
                                        </div>
                                        <div>
                                            <x-span-tag :value="__('Robot:')" />
                                            {{ $schedule['robot_name'] }}
                                        </div>
                                        <div>
                                            <x-span-tag :value="__('Vehicle:')" />
                                            <a href="{{ route('vehicles.show', $schedule['vehicle_id']) }}" class="text-blue-400 hover:underline">
                                                {{ $schedule['vehicle_name'] }}
                                            </a>
                                        </div>
                                        <div>
                                            <x-span-tag :value="__('Status:')" />
                                            @if ($schedule['is_complete'])
                                                <span class="text-green-400">Complete</span>
                                            @else
                                                <span class="text-yellow-400">In assembly</span>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="p-3 bg-gray-800 border-l-4 border-orange-500 rounded-md flex items-center gap-6">
                                        <div>
                                            <x-span-tag :value="__('Type:')" />
                                            Maintenance
                                        </div>
                                        <div>
                                            <x-span-tag :value="__('Robot:')" />
                                            {{ $schedule['robot_name'] }}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="mt-2 text-gray-400">Available</p>
                    @endif
                </div>

                @if ($slot['isAvailable'] && !$isPast)
                    <x-secondary-button href="{{ route('schedules.create', ['date' => $date, 'slot' => $slot['number']]) }}">
                        Schedule
                    </x-secondary-button>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>
