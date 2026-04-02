<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Vehicles: {{ $vehicle->name }}
        </x-header-title>

        <x-secondary-button href="{{ route('vehicles.create') }}" class="flex-end">
            Create
        </x-secondary-button>
    </x-slot>

    <form method="POST" action="{{ route('vehicles.destroy', $vehicle) }}">
        @csrf
        @method('DELETE')
        
        <div class="space-y-4">
            <div class="flex justify-between">
                <div class="flex flex-col">

                    <div>
                        <div>
                            <x-span-tag :value="__('Chassis:')" />
                            {{ $vehicle->chassis->module->name }}
                        </div>
                        <div>
                            <x-span-tag :value="__('Propulsion:')" />
                            {{ $vehicle->propulsion->module->name }}
                        </div>
                        <div>
                            <x-span-tag :value="__('Wheel:')" />
                            {{ $vehicle->wheel->module->name }}
                        </div>
                        <div>
                            <x-span-tag :value="__('Steering wheel:')" />
                            {{ $vehicle->steeringWheel->module->name }}
                        </div>
                        <div>
                            <x-span-tag :value="__('Chair:')" />
                            {{ $vehicle->chair->module->name }}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="flex items-center flex-start mt-4">
            <x-primary-button :color="'bg-rose-800 dark:bg-rose-600 hover:bg-rose-700 dark:hover:bg-rose-500 focus:bg-rose-700 dark:focus:bg-rose-500 active:bg-rose-900 dark:active:bg-rose-700'">
                Delete
            </x-primary-button>
        </div>
    </form>
</x-app-layout>