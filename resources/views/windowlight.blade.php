<x-app-layout>
    <noscript>
        <style>
            #download {
                display: none;
            }
        </style>
    </noscript>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <header class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <div class="mb-4">
                    <h1 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                        Welcome to Windowlight.
                    </h1>
                    <strong class="text-base text-gray-800 dark:text-gray-200">
                        Windowlight is a simple wrapper for Torchlight, helping you to create beautiful code screenshots.
                    </strong>
                    <noscript>
                        <p class="text-sm text-red-800 dark:text-red-500 mt-2">
                            You need to enable JavaScript to be able to download the code screenshot.
                        </p>
                    </noscript>
                </div>
            </header>
        </div>

        <div class="max-w-7xl mx-auto flex flex-wrap flex-col lg:flex-row items-stretch sm:px-3 lg:px-5">
            <div class="w-full lg:w-1/2 mx-auto px-3 mt-8">
                <section class="h-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
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
                                <x-textarea class="block mt-1 w-full" id="code" name="code" rows="8" required autofocus>{{ $input }}</x-textarea>
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            </div>

                            <footer class="text-right">
                                <x-primary-button type="submit">
                                    {{ __('Generate') }}
                                </x-primary-button>
                            </footer>
                        </form>
                    </div>
                </section>
            </div>

            @if($result)
                <div class="w-full lg:w-1/2 mx-auto px-3 mt-8">
                    <section class="h-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <header class="flex flex-row flex-wrap items-center justify-between">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                Code result
                            </h2>
                            <x-primary-button id="download" size="sm">Download</x-primary-button>
                        </header>
                        <div>
                            @include('windowlight.result')
                        </div>
                    </section>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Progressive textarea enhancements
        const textarea = document.querySelector('textarea');

        // Move the cursor to the end of the textarea when the page loads
        textarea.setSelectionRange(textarea.value.length, textarea.value.length);

        // When inside the form and using CMD/CTRL + Enter, submit the form
        textarea.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' && (event.metaKey || event.ctrlKey)) {
                event.preventDefault();
                this.form.submit();
            }
        });
    </script>
</x-app-layout>
