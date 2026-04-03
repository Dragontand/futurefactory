<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Edit Module: {{ $module->name }}
        </x-header-title>
    </x-slot>

    <form method="POST" action="{{ route('modules.update', $module) }}">
        @csrf
        @method('PATCH')

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <!-- Name -->
            <div class="sm:col-span-full">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $module->name)" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Price -->
            <div class="sm:col-span-2 sm:col-start-1">
                <x-input-label for="price" :value="__('Price')" />
                <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price', $module->price)" placeholder="In $" required/>
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>

            <!-- Time duration -->
            <div class="sm:col-span-2">
                <x-input-label for="time" :value="__('Time duration')" />
                <x-text-input id="time" class="block mt-1 w-full" type="number" name="time" :value="old('time', $module->time)" min="0" max="4" placeholder="Per 2 Ours" required/>
                <x-input-error :messages="$errors->get('time')" class="mt-2" />
            </div>

            <!-- For Chassis specific inputs -->
            @if ($module->chassis)
                <!-- Vehicle type -->
                <div class="sm:col-span-3">
                    <x-input-label for="vehicle_type" :value="__('Vehicle type')" />
                    <x-select-input id="vehicle_type" class="block mt-1 w-full" name="vehicle_type" required>
                        <option value="step" @selected(old('vehicle_type', $module->chassis->type->value) === 'step')>Step</option>
                        <option value="bicycle" @selected(old('vehicle_type', $module->chassis->type->value) === 'bicycle')>Bicycle</option>
                        <option value="scooter" @selected(old('vehicle_type', $module->chassis->type->value) === 'scooter')>Scooter</option>
                        <option value="passenger_car" @selected(old('vehicle_type', $module->chassis->type->value) === 'passenger_car')>Passenger Car</option>
                        <option value="truck" @selected(old('vehicle_type', $module->chassis->type->value) === 'truck')>Truck</option>
                        <option value="bus" @selected(old('vehicle_type', $module->chassis->type->value) === 'bus')>Bus</option>
                    </x-select-input>
                    <x-input-error :messages="$errors->get('vehicle_type')" class="mt-2" />
                </div>

                <!-- Amount of wheels -->
                <div class="sm:col-span-3">
                    <x-input-label for="amount_wheels" :value="__('Amount of wheels')" />
                    <x-text-input id="amount_wheels" class="block mt-1 w-full" type="number" name="amount_wheels" min="0" :value="old('amount_wheels', $module->chassis->amount_wheels)" required/>
                    <x-input-error :messages="$errors->get('amount_wheels')" class="mt-2" />
                </div>

                <!-- Lentgh -->
                <div class="sm:col-span-2">
                    <x-input-label for="length" :value="__('Lentgh')" />
                    <x-text-input id="length" class="block mt-1 w-full" type="number" name="length" :value="old('length', $module->chassis->length)" placeholder="In mm" required/>
                    <x-input-error :messages="$errors->get('length')" class="mt-2" />
                </div>

                <!-- Width -->
                <div class="sm:col-span-2">
                    <x-input-label for="width" :value="__('Width')" />
                    <x-text-input id="width" class="block mt-1 w-full" type="number" name="width" :value="old('width', $module->chassis->width)" placeholder="In mm" required/>
                    <x-input-error :messages="$errors->get('width')" class="mt-2" />
                </div>

                <!-- Height -->
                <div class="sm:col-span-2">
                    <x-input-label for="height" :value="__('Height')" />
                    <x-text-input id="height" class="block mt-1 w-full" type="number" name="height" :value="old('height', $module->chassis->height)" placeholder="In mm" required/>
                    <x-input-error :messages="$errors->get('height')" class="mt-2" />
                </div>
            @endif

            <!-- For Propulsion specific inputs -->
            @if ($module->propulsion)
                <!-- Propulsion type -->
                <div class="sm:col-span-3">
                    <x-input-label for="propulsion_type" :value="__('Propulsion type')" />
                    <x-select-input id="propulsion_type" class="block mt-1 w-full" name="propulsion_type" required>
                        <option value="hydrogen" @selected(old('propulsion_type', $module->propulsion->type->value) === 'hydrogen')>Hydrogen</option>
                        <option value="electric" @selected(old('propulsion_type', $module->propulsion->type->value) === 'electric')>Electric</option>
                    </x-select-input>
                    <x-input-error :messages="$errors->get('propulsion_type')" class="mt-2" />
                </div>

                <!-- Horsepower -->
                <div class="sm:col-span-3">
                    <x-input-label for="horsepower" :value="__('Horsepower')" />
                    <x-text-input id="horsepower" class="block mt-1 w-full" type="number" name="horsepower" :value="old('horsepower', $module->propulsion->horsepower)" required/>
                    <x-input-error :messages="$errors->get('horsepower')" class="mt-2" />
                </div>
            @endif

            <!-- For Wheel specific inputs -->
            @if ($module->wheel)
                <!-- Wheel type -->
                <div class="sm:col-span-3">
                    <x-input-label for="wheel_type" :value="__('Wheel type')" />
                    <x-select-input id="wheel_type" class="block mt-1 w-full" name="wheel_type" required>
                        <option value="summer" @selected(old('wheel_type', $module->wheel->type->value) === 'summer')>Summer</option>
                        <option value="winter" @selected(old('wheel_type', $module->wheel->type->value) === 'winter')>Winter</option>
                        <option value="all_season" @selected(old('wheel_type', $module->wheel->type->value) === 'all_season')>All Season</option>
                    </x-select-input>
                    <x-input-error :messages="$errors->get('wheel_type')" class="mt-2" />
                </div>

                <!-- Diameter -->
                <div class="sm:col-span-3">
                    <x-input-label for="diameter" :value="__('Diameter')" />
                    <x-text-input id="diameter" class="block mt-1 w-full" type="number" name="diameter" min="0" :value="old('diameter', $module->wheel->diameter)" placeholder="in mm" required/>
                    <x-input-error :messages="$errors->get('diameter')" class="mt-2" />
                </div>
            @endif

            <!-- For Steering wheel specific inputs -->
            @if ($module->steeringWheel)
                <!-- Steering wheel type -->
                <div class="sm:col-span-3">
                    <x-input-label for="steering_wheel_type" :value="__('Steering wheel type')" />
                    <x-select-input id="steering_wheel_type" class="block mt-1 w-full" name="steering_wheel_type" required>
                        <option value="round" @selected(old('steering_wheel_type', $module->steeringWheel->type->value) === 'round')>Round</option>
                        <option value="oval" @selected(old('steering_wheel_type', $module->steeringWheel->type->value) === 'oval')>Oval</option>
                        <option value="stadium" @selected(old('steering_wheel_type', $module->steeringWheel->type->value) === 'stadium')>Stadium</option>
                        <option value="hexagon" @selected(old('steering_wheel_type', $module->steeringWheel->type->value) === 'hexagon')>Hexagon</option>
                    </x-select-input>
                    <x-input-error :messages="$errors->get('steering_wheel_type')" class="mt-2" />
                </div>

                <!-- Special request -->
                <div class="sm:col-span-3">
                    <x-input-label for="special_request" :value="__('Special request')" />
                    <x-text-input id="special_request" class="block mt-1 w-full" type="text" name="special_request" min="0" :value="old('special_request', $module->steeringWheel->special_request)" />
                    <x-input-error :messages="$errors->get('special_request')" class="mt-2" />
                </div>
            @endif

            <!-- For Chair specific inputs -->
            @if ($module->chair)
                <!-- Upholstery type -->
                <div class="sm:col-span-3">
                    <x-input-label for="upholstery_type" :value="__('Upholstery type')" />
                    <x-select-input id="upholstery_type" class="block mt-1 w-full" name="upholstery_type" required>
                        <option value="leather" @selected(old('upholstery_type', $module->chair->type->value) === 'leather')>Leather</option>
                        <option value="fabric" @selected(old('upholstery_type', $module->chair->type->value) === 'fabric')>Fabric</option>
                        <option value="sheepskin" @selected(old('upholstery_type', $module->chair->type->value) === 'sheepskin')>Sheepskin</option>
                        <option value="artificial_leather" @selected(old('upholstery_type', $module->chair->type->value) === 'artificial_leather')>Artificial Leather</option>
                        <option value="metal" @selected(old('upholstery_type', $module->chair->type->value) === 'metal')>Metal</option>
                    </x-select-input>
                    <x-input-error :messages="$errors->get('upholstery_type')" class="mt-2" />
                </div>

                <!-- Amount of chairs -->
                <div class="sm:col-span-3">
                    <x-input-label for="amount" :value="__('Amount')" />
                    <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" min="0" :value="old('amount', $module->chair->amount)" required/>
                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                </div>
            @endif
        </div>
        <div class="flex items-center justify-between mt-4">
            <x-primary-button form="delete-form" :color="'bg-rose-800 dark:bg-rose-600 hover:bg-rose-700 dark:hover:bg-rose-500 focus:bg-rose-700 dark:focus:bg-rose-500 active:bg-rose-900 dark:active:bg-rose-700'">
                Delete
            </x-primary-button>

            <div>
                <x-secondary-button href="{{ route('modules.index') }}">
                    Cancel
                </x-secondary-button>
                
                <x-primary-button class="ms-4">
                    Save
                </x-primary-button>
            </div>
        </div>        
    </form>
    <form method="POST" action="{{ route('modules.destroy', $module) }}" id="delete-form" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>