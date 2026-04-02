<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Assemble vehicle
        </x-header-title>
    </x-slot>

    <!-- Create form -->
    @if(session('module_type'))
        <form method="POST" action="{{ route('vehicles.store') }}">
            @csrf

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                <!-- Chassis -->
                <div class="sm:col-span-3">
                    <x-input-label for="chassis" :value="__('Chassis')" />
                    <x-select-input id="chassis" class="block mt-1 w-full" name="chassis" required>
                        @foreach($chassisModules as $chassis)
                            <option value="{{ $chassis->module_id }}">{{ $chassis->module->name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('vehicle_type')" class="mt-2" />
                </div>

                <!-- Chassis -->
                <div class="sm:col-span-3">
                    <x-input-label for="chassis" :value="__('Chassis')" />
                    <x-select-input id="chassis" class="block mt-1 w-full" name="chassis" required>
                        @foreach($chassisModules as $chassis)
                            <option value="{{ $chassis->module_id }}">{{ $chassis->module->name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('vehicle_type')" class="mt-2" />
                </div>

                <!-- Chassis -->
                <div class="sm:col-span-3">
                    <x-input-label for="chassis" :value="__('Chassis')" />
                    <x-select-input id="chassis" class="block mt-1 w-full" name="chassis" required>
                        @foreach($chassisModules as $chassis)
                            <option value="{{ $chassis->module_id }}">{{ $chassis->module->name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('vehicle_type')" class="mt-2" />
                </div>

                <!-- Chassis -->
                <div class="sm:col-span-3">
                    <x-input-label for="chassis" :value="__('Chassis')" />
                    <x-select-input id="chassis" class="block mt-1 w-full" name="chassis" required>
                        @foreach($chassisModules as $chassis)
                            <option value="{{ $chassis->module_id }}">{{ $chassis->module->name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('vehicle_type')" class="mt-2" />
                </div>

                <!-- Chassis -->
                <div class="sm:col-span-3">
                    <x-input-label for="chassis" :value="__('Chassis')" />
                    <x-select-input id="chassis" class="block mt-1 w-full" name="chassis" required>
                        @foreach($chassisModules as $chassis)
                            <option value="{{ $chassis->module_id }}">{{ $chassis->module->name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('vehicle_type')" class="mt-2" />
                </div>
                
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-secondary-button href="{{ route('modules.cancel') }}">
                    Cancel
                </x-secondary-button>

                <x-primary-button class="ms-4">
                    Save
                </x-primary-button>
            </div>
        </form>
    @endif
</x-app-layout>