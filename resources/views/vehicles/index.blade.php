<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Vehicles
        </x-header-title>

        <x-secondary-button href="{{ route('vehicles.create') }}" class="flex-end">
            Assemble
        </x-secondary-button>
    </x-slot>
    <div class="space-y-4">
        @foreach ($vehicles as $vehicle)
            <a href="{{ route('vehicles.show', $vehicle) }}" class="block px-4 py-6 border border-gray-600 rounded-lg">
                <div class="font-bold text-blue-500 text-xl">{{ ucfirst($vehicle->name) }}</div>
                <div class="flex justify-between">
                    <div class="flex flex-col">
                        <div>
                            <x-span-tag :value="__('Chassis:')" />
                            {{ $vehicle->chassis->module->name }}
                            <span class="text-gray-400">({{ ucfirst(str_replace('_', ' ', $vehicle->chassis->type->value)) }})</span>
                        </div>
                        <div>
                            <x-span-tag :value="__('Propulsion:')" />
                            {{ $vehicle->propulsion->module->name }}
                            <span class="text-gray-400">({{ ucfirst($vehicle->propulsion->type->value) }})</span>
                        </div>
                        <div>
                            <x-span-tag :value="__('Wheel:')" />
                            {{ $vehicle->wheel->module->name }}
                            <span class="text-gray-400">({{ ucfirst(str_replace('_', ' ', $vehicle->wheel->type->value)) }})</span>
                        </div>
                        <div>
                            <x-span-tag :value="__('Steering wheel:')" />
                            {{ $vehicle->steeringWheel->module->name }}
                            <span class="text-gray-400">({{ ucfirst($vehicle->steeringWheel->type->value) }})</span>
                        </div>
                        <div>
                            <x-span-tag :value="__('Chair:')" />
                            {{ $vehicle->chair->module->name }}
                            <span class="text-gray-400">({{ ucfirst(str_replace('_', ' ', $vehicle->chair->type->value)) }})</span>
                        </div>
                        <div>
                            <x-span-tag :value="__('Total:')" />
                            ${{ $vehicle->calcTotalPrice() }}
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
        <div>
            {{ $vehicles->links(); }}
        </div>
    </div>
</x-app-layout>

