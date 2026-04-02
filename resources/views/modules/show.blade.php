<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            {{ $module->getTypeLabel() }} Module
        </x-header-title>

        <x-secondary-button href="{{ route('modules.create') }}" class="flex-end">
            Create
        </x-secondary-button>
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
                        {{ $module->chassis->type }}
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
                        {{ $module->propulsion->type }}
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
                        {{ $module->wheel->type }}
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
                        {{ $module->steeringWheel->type }}
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
                        {{ $module->chair->type }}
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