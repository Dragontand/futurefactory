<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            @if (!session('module_type'))
                Create Module
            @else
                {{ ucfirst(session('module_type')) }}
            @endif
        </x-header-title>
    </x-slot>

    <!-- Module type -->
    @if (!session('module_type'))
        <form method="POST" action="{{ route('modules.storeType') }}">
            @csrf

            <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                <x-input-label :value="__('Type module')" />
                <div class="flex gap-3 col-span-full">
                    @foreach ($modules as $value => $label)
                    <label for="{{ $value }}"
                        class="flex items-center pl-4 pr-6 py-3 border border-gray-600 bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-700 transition-colors">

                        <input type="radio" @if ($loop->first) { {{ "checked" }} } @endif name="type" id="{{ $value }}" value="{{ $value }}"
                            class="w-4 h-4 text-blue-600 bg-gray-900 border-gray-500 rounded-full focus:ring-2 focus:ring-blue-500 focus:outline-none cursor-pointer">

                        <span class="ml-3 text-sm font-medium text-gray-200 select-none">
                            {{ $label }}
                        </span>

                    </label>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-secondary-button href="{{ route('modules.index') }}">
                    Cancel
                </x-secondary-button>

                <x-primary-button class="ms-4">
                    Next
                </x-primary-button>
            </div>
        </form>
    @else
        <form method="POST" action="{{ route('modules.store') }}">
            @csrf

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <!-- Name -->
                <div class="sm:col-span-full">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Price -->
                <div class="sm:col-span-2 sm:col-start-1">
                    <x-input-label for="price" :value="__('Price')" />
                    <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price')" placeholder="In $" required/>
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <!-- Time duration -->
                <div class="sm:col-span-2">
                    <x-input-label for="time" :value="__('Time duration')" />
                    <x-text-input id="time" class="block mt-1 w-full" type="number" name="time" :value="old('time')" min="0" max="4" placeholder="Per 2 Ours" required/>
                    <x-input-error :messages="$errors->get('time')" class="mt-2" />
                </div>

                <!-- For Chassis specific inputs -->
                @if (session('module_type') === array_keys($modules)[0])
                    <!-- Vehicle type -->
                    <div class="sm:col-span-3">
                        <x-input-label for="vehicle_type" :value="__('Vehicle type')" />
                        <x-select-input id="vehicle_type" class="block mt-1 w-full" name="vehicle_type" required>
                            <option value="step" @selected(old('vehicle_type') === 'step')>Step</option>
                            <option value="bicycle" @selected(old('vehicle_type') === 'bicycle')>Bicycle</option>
                            <option value="scooter" @selected(old('vehicle_type') === 'scooter')>Scooter</option>
                            <option value="passenger_car" @selected(old('vehicle_type') === 'passenger_car')>Passenger Car</option>
                            <option value="truck" @selected(old('vehicle_type') === 'truck')>Truck</option>
                            <option value="bus" @selected(old('vehicle_type') === 'bus')>Bus</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('vehicle_type')" class="mt-2" />
                    </div>

                    <!-- Amount of wheels -->
                    <div class="sm:col-span-3">
                        <x-input-label for="amount_wheels" :value="__('Amount of wheels')" />
                        <x-text-input id="amount_wheels" class="block mt-1 w-full" type="number" name="amount_wheels" min="0" :value="old('amount_wheels')" required/>
                        <x-input-error :messages="$errors->get('amount_wheels')" class="mt-2" />
                    </div>

                    <!-- Lentgh -->
                    <div class="sm:col-span-2">
                        <x-input-label for="length" :value="__('Lentgh')" />
                        <x-text-input id="length" class="block mt-1 w-full" type="number" name="length" :value="old('length')" placeholder="In mm" required/>
                        <x-input-error :messages="$errors->get('length')" class="mt-2" />
                    </div>

                    <!-- Width -->
                    <div class="sm:col-span-2">
                        <x-input-label for="width" :value="__('Width')" />
                        <x-text-input id="width" class="block mt-1 w-full" type="number" name="width" :value="old('width')" placeholder="In mm" required/>
                        <x-input-error :messages="$errors->get('width')" class="mt-2" />
                    </div>

                    <!-- Height -->
                    <div class="sm:col-span-2">
                        <x-input-label for="height" :value="__('Height')" />
                        <x-text-input id="height" class="block mt-1 w-full" type="number" name="height" :value="old('height')" placeholder="In mm" required/>
                        <x-input-error :messages="$errors->get('height')" class="mt-2" />
                    </div>
                @endif

                <!-- For Propulsion specific inputs -->
                @if (session('module_type') === array_keys($modules)[1])
                    <!-- Propulsion type -->
                    <div class="sm:col-span-3">
                        <x-input-label for="propulsion_type" :value="__('Propulsion type')" />
                        <x-select-input id="propulsion_type" class="block mt-1 w-full" name="propulsion_type" required>
                            <option value="hydrogen" @selected(old('propulsion_type') === 'hydrogen')>Hydrogen</option>
                            <option value="electric" @selected(old('propulsion_type') === 'electric')>Electric</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('propulsion_type')" class="mt-2" />
                    </div>

                    <!-- Horsepower -->
                    <div class="sm:col-span-3">
                        <x-input-label for="horsepower" :value="__('Horsepower')" />
                        <x-text-input id="horsepower" class="block mt-1 w-full" type="number" name="horsepower" :value="old('horsepower')" required/>
                        <x-input-error :messages="$errors->get('horsepower')" class="mt-2" />
                    </div>
                @endif

                <!-- For Wheel specific inputs -->
                @if (session('module_type') === array_keys($modules)[2])
                    <!-- Wheel type -->
                    <div class="sm:col-span-3">
                        <x-input-label for="wheel_type" :value="__('Wheel type')" />
                        <x-select-input id="wheel_type" class="block mt-1 w-full" name="wheel_type" required>
                            <option value="summer" @selected(old('wheel_type') === 'summer')>Summer</option>
                            <option value="winter" @selected(old('wheel_type') === 'winter')>Winter</option>
                            <option value="all_season" @selected(old('wheel_type') === 'all_season')>All Season</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('wheel_type')" class="mt-2" />
                    </div>

                    <!-- Diameter -->
                    <div class="sm:col-span-3">
                        <x-input-label for="diameter" :value="__('Diameter')" />
                        <x-text-input id="diameter" class="block mt-1 w-full" type="number" name="diameter" min="0" :value="old('diameter')" placeholder="in mm" required/>
                        <x-input-error :messages="$errors->get('diameter')" class="mt-2" />
                    </div>
                @endif

                <!-- For Steering wheel specific inputs -->
                @if (session('module_type') === array_keys($modules)[3])
                    <!-- Steering wheel type -->
                    <div class="sm:col-span-3">
                        <x-input-label for="steering_wheel_type" :value="__('Steering wheel type')" />
                        <x-select-input id="steering_wheel_type" class="block mt-1 w-full" name="steering_wheel_type" required>
                            <option value="round" @selected(old('steering_wheel_type') === 'round')>Round</option>
                            <option value="oval" @selected(old('steering_wheel_type') === 'oval')>Oval</option>
                            <option value="stadium" @selected(old('steering_wheel_type') === 'stadium')>Stadium</option>
                            <option value="hexagon" @selected(old('steering_wheel_type') === 'hexagon')>Hexagon</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('steering_wheel_type')" class="mt-2" />
                    </div>

                    <!-- Special request -->
                    <div class="sm:col-span-3">
                        <x-input-label for="special_request" :value="__('Special request')" />
                        <x-text-input id="special_request" class="block mt-1 w-full" type="text" name="special_request" min="0" :value="old('special_request')" />
                        <x-input-error :messages="$errors->get('special_request')" class="mt-2" />
                    </div>
                @endif

                <!-- For Chair specific inputs -->
                @if (session('module_type') === array_keys($modules)[4])
                    <!-- Upholstery type -->
                    <div class="sm:col-span-3">
                        <x-input-label for="upholstery_type" :value="__('Upholstery type')" />
                        <x-select-input id="upholstery_type" class="block mt-1 w-full" name="upholstery_type" required>
                            <option value="leather" @selected(old('upholstery_type') === 'leather')>Leather</option>
                            <option value="fabric" @selected(old('upholstery_type') === 'fabric')>Fabric</option>
                            <option value="sheepskin" @selected(old('upholstery_type') === 'sheepskin')>Sheepskin</option>
                            <option value="artificial_leather" @selected(old('upholstery_type') === 'artificial_leather')>Artificial Leather</option>
                            <option value="metal" @selected(old('upholstery_type') === 'metal')>Metal</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('upholstery_type')" class="mt-2" />
                    </div>

                    <!-- Amount of chairs -->
                    <div class="sm:col-span-3">
                        <x-input-label for="amount" :value="__('Amount')" />
                        <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" min="0" :value="old('amount')" required/>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                @endif
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-secondary-button href="{{ route('modules.cancel') }}">
                    Back
                </x-secondary-button>

                @if (session('module_type'))
                    <x-secondary-button class="ms-4" href="{{ route('modules.index') }}">
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