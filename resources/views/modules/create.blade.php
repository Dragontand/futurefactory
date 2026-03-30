<x-app-layout>
    <x-slot name="header">
        <x-header-title>
            Create Module
        </x-header-title>
    </x-slot>

    <form method="POST" action="{{ route('modules.store') }}" x-data="{ type: '{{ old('type', '') }}' }>
        @csrf

        <!-- Module type -->
        <div class="mt-4">
            <x-input-label :value="__('Type module')" />
            <div class="flex gap-3">
                @foreach (['particulier' => 'Particulier', 'bedrijf' => 'Bedrijf', 'overheid' => 'Overheid'] as $value
                => $label)
                <label class="cursor-pointer">
                    <input type="radio" name="type" value="{{ $value }}" x-model="type" class="sr-only peer" {{
                        old('type') === $value ? 'checked' : '' }}>
                    <span
                        class="inline-block px-5 py-2 rounded-lg border text-sm transition-all duration-150 cursor-pointer select-none
                                 border-gray-200 text-gray-500 bg-white
                                 hover:border-gray-400 hover:text-gray-700
                                 peer-checked:border-gray-900 peer-checked:bg-gray-900 peer-checked:text-white peer-checked:font-medium">
                        {{ $label }}
                    </span>    
                </label>
                @endforeach
            </div>
            <x-input-error :messages="$errors->get($value)" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Price -->
        <div class="mt-4">
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price')"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-secondary-button href="{{ route('modules.index') }}">
                Cancel
            </x-secondary-button>

            <x-primary-button href="{{ route('modules.store') }}" class="ms-4">
                Save
            </x-primary-button>
        </div>
    </form>
</x-app-layout>