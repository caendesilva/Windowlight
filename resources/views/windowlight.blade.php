<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <header class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <h1 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                        Welcome to Windowlight.
                    </h1>
                    <strong class="text-base text-gray-800 dark:text-gray-200">
                        Windowlight is a simple wrapper for Torchlight, helping you to create beautiful code screenshots.
                    </strong>
                </div>
            </header>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('windowlight.store') }}">
                        <header class="mb-4">
                            <label for="code">
                                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                    Enter code
                                </h2>
                            </label>
                        </header>

                        @csrf

                        <div class="mb-4">
                            <x-textarea class="block mt-1 w-full" name="code" rows="8" required autofocus>{{ $example }}</x-textarea>
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <x-primary-button type="submit">
                            {{ __('Generate') }}
                        </x-primary-button>
                    </form>
                </div>
            </section>
        </div>

        @if($result)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
                <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <header>
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Code result
                        </h2>
                    </header>
                    <div>
                        @include('windowlight.result')
                    </div>
                </section>
            </div>
        @endif
    </div>
</x-app-layout>
