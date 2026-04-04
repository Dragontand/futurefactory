<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Create Schedule
        </x-header-title>
    </x-slot>

    {{-- Date & slot info --}}
    <div class="sm:col-span-3">
        <x-span-tag :value="__('Date')" />
        <p class="mt-1 text-gray-300">{{ $date }}</p>
        <x-input-error :messages="$errors->get('date')" class="mt-2" />
    </div>

    <div class="sm:col-span-3">
        <x-span-tag :value="__('Slot')" />
        <p class="mt-1 text-gray-300">No. {{ $slot }}</p>
        <x-input-error :messages="$errors->get('slot')" class="mt-2" />
    </div>

    {{-- Type selection --}}
    @if (!session('schedule_type'))
        <form method="POST" action="{{ route('schedules.storeType') }}">
            @csrf

            <input type="hidden" name="date" value="{{ $date }}">
            <input type="hidden" name="slot" value="{{ $slot }}">

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-full">
                    <x-input-label :value="__('Type')" />
                    <div class="flex gap-3 col-span-full mt-1">
                        @foreach (['assembly' => 'Assembly', 'maintenance' => 'Maintenance'] as $value => $label)
                        <label for="{{ $value }}"
                            class="flex items-center pl-4 pr-6 py-3 border border-gray-600 bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-700 transition-colors">

                            <input type="radio" @if ($loop->first) checked @endif name="type" id="{{ $value }}" value="{{ $value
                            }}"
                            class="w-4 h-4 text-blue-600 bg-gray-900 border-gray-500 rounded-full focus:ring-2
                            focus:ring-blue-500 focus:outline-none cursor-pointer">

                            <span class="ml-3 text-sm font-medium text-gray-200 select-none">
                                {{ $label }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-secondary-button href="{{ route('schedules.show', ['date' => $date]) }}">
                        Cancel
                    </x-secondary-button>

                    <x-primary-button class="ms-4">
                        Next
                    </x-primary-button>
                </div>
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('schedules.store') }}">
            @csrf

            <input type="hidden" name="date" value="{{ $date }}">
            <input type="hidden" name="slot" value="{{ $slot }}">
            <input type="hidden" name="type" value="{{ session('schedule_type') }}">

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                {{-- Vehicle selection (for assembly) --}}
                @if (session('schedule_type') === array_keys($scheduleTypes)[0])
                    <div class="sm:col-span-3">
                        <x-input-label for="vehicle_id" :value="__('Vehicle (for assembly)')" />
                        <x-select-input id="vehicle_id" class="block mt-1 w-full" name="vehicle_id">
                            <option value="">— Select vehicle —</option>
                            @foreach ($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" @selected(old('vehicle_id')==$vehicle->id)>
                                {{ $vehicle->name }}
                            </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('vehicle_id')" class="mt-2" />
                    </div>
                @endif

                {{-- Robot selection (for maintenance) --}}
                @if (session('schedule_type') === array_keys($scheduleTypes)[1])
                    <div class="sm:col-span-3">
                        <x-input-label for="robot_id" :value="__('Robot (for maintenance)')" />
                        <x-select-input id="robot_id" class="block mt-1 w-full" name="robot_id">
                            <option value="">— Select robot —</option>
                            @foreach ($robots as $robot)
                            <option value="{{ $robot->id }}" @selected(old('robot_id')==$robot->id)>
                                {{ $robot->name }}
                            </option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('robot_id')" class="mt-2" />
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-secondary-button href="{{ route('schedules.cancel', ['date' => $date, 'slot' => $slot]) }}">
                    Back
                </x-secondary-button>

                @if (session('schedule_type'))
                    <x-secondary-button class="ms-4" href="{{ route('schedules.show',  ['date' => $date]) }}">
                        Cancel
                    </x-secondary-button>
                @endif

                <x-primary-button class="ms-4">
                    Save
                </x-primary-button>
            </div>
        </form>
    @endif
</x-app-layout>