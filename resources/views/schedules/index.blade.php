<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Schedule
        </x-header-title>
    </x-slot>

    <section class="relative py-8 sm:p-8">
        <div class="w-full max-w-7xl mx-auto px-4 lg:px-8 xl:px-14">
            {{-- Header --}}
            <div class="flex items-center justify-between gap-3 mb-2">
                <div class="flex items-center gap-4">
                    <h5 class="text-xl leading-8 font-semibold text-white min-w-[10rem]">
                        {{ $months['viewMonth'] }}
                    </h5>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('schedules.index', ['month' => $months['prevMonth']]) }}"
                           class="text-gray-500 rounded transition-all duration-300 hover:bg-gray-100 hover:text-gray-900 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                        <a href="{{ route('schedules.index', ['month' => $months['nextMonth']]) }}"
                           class="text-gray-500 rounded transition-all duration-300 hover:bg-gray-100 hover:text-gray-900 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M6.00236 3.99707L10.0025 7.99723L6 11.9998" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                    @unless ($months['isCurrentMonth'])
                        <a href="{{ route('schedules.index', ['month' => $months['curMonth']]) }}">
                            Today
                        </a>
                    @endunless
                </div>
            </div>

            {{-- Calendar grid --}}
            <div class="border border-gray-100 dark:border-gray-400 rounded-lg overflow-hidden">
                
                {{-- Day headers --}}
                <div class="grid grid-cols-5 border-b border-gray-100 dark:border-gray-400 text-white text-sm font-medium font-bold">
                    @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $dayName)
                        <div class="p-3.5 flex items-center justify-center {{ !$loop->last ? 'border-r border-gray-100 dark:border-gray-400' : '' }}">
                            <span>
                                {{ $dayName }}
                            </span>
                        </div>
                    @endforeach
                </div>

                {{-- Day cells --}}
                <div class="grid grid-cols-5">
                    @foreach ($days as $day)
                        <a href="{{ route('schedules.show', ['date' => $day['date']]) }}"
                           class="group p-3.5 xl:aspect-auto lg:h-28 border-b border-gray-100 dark:border-gray-400 {{ $loop->iteration % 5 !== 0 ? 'border-r' : '' }} flex justify-between flex-col max-lg:items-center min-h-[70px] transition-all duration-300 hover:bg-gray-100
                            {{ $day['isCurrentMonth'] ? 'bg-gray-800' : 'bg-gray-500' }}">

                            {{-- Day number --}}
                            <span class="text-xs font-semibold flex items-center justify-center w-7 h-7 rounded-full
                                {{ $day['isToday'] ? 'text-gray-800 bg-indigo-600' : ($day['isCurrentMonth'] ? 'text-white group-hover:text-gray-800' : 'text-gray-400 group-hover:text-gray-800') }}">
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
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Vehicle overview --}}
        <div class="w-full max-w-7xl mx-auto px-4 lg:px-8 xl:px-14 mt-8">
            <h5 class="text-xl leading-8 font-semibold text-white mb-4">
                Vehicle Overview
            </h5>

            <div class="border border-gray-400 rounded-lg overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="text-white font-bold border-b border-gray-400">
                        <tr>
                            <th class="px-4 py-3">Vehicle</th>
                            <th class="px-4 py-3">Progress</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Expected Completion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehicles as $vehicle)
                            <tr class="border-b border-gray-600">
                                <td class="px-4 py-3 text-gray-200">{{ $vehicle['name'] }}</td>
                                <td class="px-4 py-3 text-gray-300">{{ $vehicle['completedSlots'] }} / {{ $vehicle['totalSlots'] }} slots</td>
                                <td class="px-4 py-3">
                                    @if ($vehicle['isComplete'])
                                        <span class="text-green-400">Complete</span>
                                    @elseif ($vehicle['isScheduled'])
                                        <span class="text-yellow-400">In production</span>
                                    @else
                                        <span class="text-gray-400">Not scheduled</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-300">{{ $vehicle['expectedDate'] ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
