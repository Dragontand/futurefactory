<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Schedule
        </x-header-title>
    </x-slot>

    <section class="relative py-8 sm:p-8">
        <div class="w-full max-w-7xl mx-auto px-4 lg:px-8 xl:px-14">
            {{-- Header --}}
            <div class="flex items-center justify-between gap-3 mb-5">
                <div class="flex items-center gap-4">
                    <h5 class="text-xl leading-8 font-semibold text-gray-900">
                        {{ $currentMonth }}
                    </h5>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('schedules.index', ['month' => $prevMonth]) }}"
                           class="text-gray-500 rounded transition-all duration-300 hover:bg-gray-100 hover:text-gray-900 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                        <a href="{{ route('schedules.index', ['month' => $nextMonth]) }}"
                           class="text-gray-500 rounded transition-all duration-300 hover:bg-gray-100 hover:text-gray-900 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M6.00236 3.99707L10.0025 7.99723L6 11.9998" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Calendar grid --}}
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                
                {{-- Day headers --}}
                <div class="grid grid-cols-7 border-b border-gray-200">
                    @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dayName)
                        <div class="p-3.5 flex items-center justify-center {{ !$loop->last ? 'border-r border-gray-200' : '' }}">
                            <span class="text-sm font-medium text-gray-500">
                                {{ $dayName }}
                            </span>
                        </div>
                    @endforeach
                </div>

                {{-- Day cells --}}
                <div class="grid grid-cols-7">
                    @foreach ($days as $day)
                        <div class="p-3.5 xl:aspect-auto lg:h-28 border-b border-gray-200 {{ !$loop->iteration % 7 == 0 ? '' : 'border-r' }} flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100
                            {{ $day['isCurrentMonth'] ? '' : 'bg-gray-50' }}">

                            {{-- Day number --}}
                            <span class="text-xs font-semibold flex items-center justify-center w-7 h-7 rounded-full
                                {{ $day['isToday'] ? 'text-white bg-indigo-600' : ($day['isCurrentMonth'] ? 'text-gray-900' : 'text-gray-500') }}">
                                {{ $day['number'] }}
                            </span>

                            {{-- Events --}}
                            @if (!empty($day['events']))
                                @foreach ($day['events'] as $event)
                                    <span class="hidden lg:block text-xs font-medium text-gray-500 truncate w-full">
                                        {{ $event }}
                                    </span>
                                    <span class="lg:hidden w-2 h-2 rounded-full bg-gray-400"></span>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
