<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            {{ $module->getTypeLabel() }} Module
        </x-header-title>

        <div>
            <x-secondary-button class="flex-end" href="{{ route('modules.create') }}">
                Create
            </x-secondary-button>

            <x-secondary-button class="ms-4" href="{{ route('modules.index') }}">
                Back
            </x-secondary-button>
        </div>
    </x-slot>
    
    <div class="space-y-4">
        <div class="font-bold text-blue-500 text-xl">
            {{ ucfirst($module->name) }}
        </div>
        <div class="flex justify-between">
            <div class="flex flex-col">
                <div>
                    <div>
                        <x-span-tag :value="__('Price:')" />
                        ${{ $module->price }}
                    </div>
                    <div>
                        <x-span-tag :value="__('Time:')" />
                        {{ $module->time }}
                    </div>
                </div>

                <!-- For Chassis specific fields -->
                @if ($module->chassis)
                <div>
                    <div>
                        <x-span-tag :value="__('Vehicle type:')" />
                        {{ ucfirst(str_replace('_', ' ', $module->chassis->type->value)) }}
                    </div>
                    <div>
                        <x-span-tag :value="__('Amount of wheels:')" />
                        {{ $module->chassis->amount_wheels }}
                    </div>
                    <div class="mt-2">
                        <x-span-tag :value="__('Length:')" />
                        {{ $module->chassis->length }} mm
                    </div>
                    <div>
                        <x-span-tag :value="__('Width:')" />
                        {{ $module->chassis->width }} mm
                    </div>
                    <div>
                        <x-span-tag :value="__('Height:')" />
                        {{ $module->chassis->height }} mm
                    </div>
                </div>

                <!-- For Propulsion specific fields -->
                @elseif ($module->propulsion)
                <div>
                    <div>
                        <x-span-tag :value="__('Propulsion type:')" />
                        {{ ucfirst(str_replace('_', ' ', $module->propulsion->type->value)) }}
                    </div>
                    <div>
                        <x-span-tag :value="__('Horsepower:')" />
                        {{ $module->propulsion->horsepower }}
                    </div>
                </div>

                <!-- For Wheel specific fields -->
                @elseif ($module->wheel)
                <div>
                    <div>
                        <x-span-tag :value="__('Wheel type:')" />
                        {{ ucfirst(str_replace('_', ' ', $module->wheel->type->value)) }}
                    </div>
                    <div>
                        <x-span-tag :value="__('Diameter:')" />
                        {{ $module->wheel->diameter }} mm
                    </div>
                    @foreach ($module->wheel->compatibleChassis as $chassis)
                        @if ($loop->first)
                            <div>
                                <x-span-tag :value="__('Geschikte chassis:')" />
                            </div>
                        @endif
                        <div>
                            <x-inline-link href="{{ route('modules.show', $chassis->module_id) }}">
                                - {{ $chassis->module->name }}
                            </x-inline-link>
                        </div>
                    @endforeach
                </div>

                <!-- For Steering wheel specific fields -->
                @elseif ($module->steeringWheel)
                <div>
                    <div>
                        <x-span-tag :value="__('Steering wheel type:')" />
                        {{ ucfirst(str_replace('_', ' ', $module->steeringWheel->type->value)) }}
                    </div>
                    <div>
                        <x-span-tag :value="__('Special request:')" />
                        {{ $module->steeringWheel->special_request }}
                    </div>
                </div>

                <!-- For Chair specific fields -->
                @elseif ($module->chair)
                <div>
                    <div>
                        <x-span-tag :value="__('Chair type:')" />
                        {{ ucfirst(str_replace('_', ' ', $module->chair->type->value)) }}
                    </div>
                    <div>
                        <x-span-tag :value="__('Amount:')" />
                        {{ $module->chair->amount }}
                    </div>
                </div>

                @endif

            </div>
            <img src="{{ $module->image }}" alt="" class="max-w-[150px] max-h-[100px]">
        </div>
        <x-secondary-button href="{{ route('modules.edit', $module) }}">
            Edit
        </x-secondary-button>
    </div>
</x-app-layout>