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

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('windowlight.store') }}">
                        @csrf

                        <div class="flex flex-col lg:flex-row -mx-4">
                            <fieldset class="w-full lg:w-1/2 xl:w-2/3 px-4">
                                <legend class="mb-2">
                                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                        Code
                                    </h2>
                                </legend>
                                <div class="mb-4">
                                    <x-input-label for="code" value="Code input" />
                                    <x-textarea class="block mt-1 w-full" id="code" name="code" rows="8" required autofocus>{{ $input }}</x-textarea>
                                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                                </div>
                            </fieldset>

                            <fieldset class="w-full lg:w-1/2 px-4">
                                <legend class="mb-2">
                                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                        Options
                                    </h2>
                                </legend>
                                <div class="mb-4">
                                    <x-input-label for="language" value="Language" />
                                    <x-text-input id="language" name="language" type="text" list="languages" value="{{ $language }}" class="w-48" />
                                    <x-input-error :messages="$errors->get('language')" class="mt-2" />
                                    <datalist id="languages">
                                        {!! implode('', array_map(fn(string $languageOption) => "<option value=\"$languageOption\" />", \App\Contracts\Torchlight::LANGUAGES)) !!}
                                    </datalist>
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="lineNumbers" value="Line numbers" />
                                    <x-select-input id="lineNumbers" name="lineNumbers" class="w-48">
                                        <option value="true" {{ $lineNumbers === true ? 'selected' : ''}}>Use line numbers</option>
                                        <option value="false" {{ $lineNumbers === false ? 'selected' : ''}}>No line numbers</option>
                                    </x-select-input>
                                    <x-input-error :messages="$errors->get('lineNumbers')" class="mt-2" />
                                </div>
                            </fieldset>
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
                <section class="h-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <header class="flex flex-row flex-wrap items-center justify-between">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Code result
                        </h2>
                        <x-primary-button id="download">Download</x-primary-button>
                    </header>
                    <div>
                        @include('windowlight.result')
                    </div>
                </section>
            </div>
        @endif
    </div>

    <script>
        // Progressive textarea enhancements
        const textarea = document.querySelector('textarea');

        // Move the cursor to the end of the textarea when the page loads
        textarea.setSelectionRange(textarea.value.length, textarea.value.length);

        // When inside the form and using CMD/CTRL + Enter, submit the form
        textarea.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' && (event.metaKey || event.ctrlKey)) {
                event.preventDefault();
                this.form.submit();
            }
        });
    </script>

    <script>
        // Download the code screenshot

        const downloadButton = document.getElementById('download');

        downloadButton.addEventListener('click', function () {
            render();
        });

        function render() {
            const codeCard = document.getElementById('code-card-wrapper');

            html2canvas(codeCard, {
                scale: 4, // Increase DPI (Resolution)
            }).then(canvas => {
                downloadImage(canvas.toDataURL());
            });
        }

        async function downloadImage(data) {
            const link = document.createElement('a');
            link.href = data;
            link.download = "windowlight-{{ substr($resultId, 0, 8) }}.png";
            link.click();
            link.remove();
        }
    </script>

    <script defer src="{{ asset('vendor/html2canvas.min.js') }}"></script>
</x-app-layout>
