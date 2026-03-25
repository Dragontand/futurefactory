<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Modules
        </x-header-title>

        <x-secondary-button href="{{ route('modules.create') }}" class="flex-end">
            Create
        </x-secondary-button>
    </x-slot>
    <div class="space-y-4">
        {{-- @foreach ($modules as $module)
            <a href="/modules/{{ $module['id'] }}" class="block px-4 py-6 border border-gray-600 rounded-lg">
                <div class="font-bold text-blue-500">{{ $job->employer->name }}</div>
                <div>
                    <strong>{{ $job['title'] }}:</strong> {{ $job['salary'] }} per year.
                </div>
            </a>
        @endforeach
        <div>
            {{ $modules->links(); }}
        </div> --}}
    </div>
</x-app-layout>

