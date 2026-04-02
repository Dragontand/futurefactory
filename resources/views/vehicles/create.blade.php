<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Assemble vehicle
        </x-header-title>
    </x-slot>

    <!-- Create form -->
    <form method="POST" action="{{ isset($selectedChassis) ? route('vehicles.store') : route('vehicles.create-step2') }}">
        @csrf

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

            <!-- Name -->
            <div class="sm:col-span-3">
                <div class="sm:col-span-full">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ isset($name) ? old('name', $name) : old('name') }}" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <!-- Chassis -->
            <div class="sm:col-span-3">
                <x-input-label for="chassis" :value="__('Chassis')" />
                <x-select-input id="chassis" class="block mt-1 w-full" name="chassis_module_id" required>
                    @if (isset($selectedChassis))
                        <option value="{{ $selectedChassis->module_id }}">{{ $selectedChassis->module->name }}  -  ${{ number_format($selectedChassis->module->price, 2) }}</option>
                    @else
                        <option value="">--</option>
                        @foreach($chassisModules as $chassis)
                            <option value="{{ $chassis->module_id }}">{{ $chassis->module->name }}  -  ${{ number_format($chassis->module->price, 2) }}</option>
                        @endforeach
                    @endif
                </x-select-input>
                <x-input-error :messages="$errors->get('chassis_module_id')" class="mt-2" />
            </div>

            @isset($selectedChassis)
                <!-- Propulsion -->
                <div class="sm:col-span-3">
                    <x-input-label for="propulsion" :value="__('Propulsion')" />
                    <x-select-input id="propulsion" class="block mt-1 w-full" name="propulsion_module_id" required>
                        <option value="">--</option>
                        @foreach($propulsionModules as $propulsion)
                            <option value="{{ $propulsion->module_id }}">{{ $propulsion->module->name }}  -  ${{ number_format($propulsion->module->price, 2) }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('propulsion_module_id')" class="mt-2" />
                </div>

                <!-- Wheel -->
                <div class="sm:col-span-3">
                    <x-input-label for="wheel" :value="__('Wheel')" />
                    <x-select-input id="wheel" class="block mt-1 w-full" name="wheel_module_id" required>
                        <option value="">--</option>
                        @foreach($wheelModules as $wheel)
                            <option value="{{ $wheel->module_id }}">{{ $wheel->module->name }}  -  ${{ number_format($wheel->module->price, 2) }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('wheel_module_id')" class="mt-2" />
                </div>

                <!-- Steering wheel -->
                <div class="sm:col-span-3">
                    <x-input-label for="steering-wheel" :value="__('Steering wheel')" />
                    <x-select-input id="steering-wheel" class="block mt-1 w-full" name="steering_wheel_module_id" required>
                        <option value="">--</option>
                        @foreach($steeringWheelModules as $steeringWheel)
                            <option value="{{ $steeringWheel->module_id }}">{{ $steeringWheel->module->name }}  -  ${{ number_format($steeringWheel->module->price, 2) }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('steering_wheel_module_id')" class="mt-2" />
                </div>

                <!-- Chair -->
                <div class="sm:col-span-3">
                    <x-input-label for="chair" :value="__('Chair')" />
                    <x-select-input id="chair" class="block mt-1 w-full" name="chair_module_id" required>
                        <option value="">--</option>
                        @foreach($chairModules as $chair)
                            <option value="{{ $chair->module_id }}">{{ $chair->module->name }}  -  ${{ number_format($chair->module->price, 2) }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('chair_module_id')" class="mt-2" />
                </div>
            @endisset
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-secondary-button href="{{ route('vehicles.index') }}">
                Cancel
            </x-secondary-button>

            @isset($selectedChassis)
                <x-secondary-button class="ms-4" href="{{ route('vehicles.create') }}">
                    Back
                </x-secondary-button>
            @endisset

            <x-primary-button class="ms-4">
                {{ isset($selectedChassis) ? 'Save' : 'Next' }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>