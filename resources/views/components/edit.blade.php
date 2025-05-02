<x-app-layout>
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <form method="post" action="{{ route('users.update', $user) }}">
            @csrf
            @method('patch')

            <div class="mb-6">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="mb-6">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                    :value="old('email', $user->email)" required autocomplete="email" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <x-cancel-button href="{{ route('users.index') }}" />
            </div>
        </form>
    </div>
</x-app-layout>