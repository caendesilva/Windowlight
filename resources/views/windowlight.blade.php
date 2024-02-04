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
                <div>
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
                                    <x-textarea class="block w-full" id="code" name="code" rows="8" required autofocus>{{ $input }}</x-textarea>
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
                                    <x-text-input id="language" name="language" type="text" list="languages" value="{{ $language }}" placeholder="php" class="w-48" />
                                    <x-input-error :messages="$errors->get('language')" class="mt-2" />
                                    <datalist id="languages">
                                        {{ \App\Contracts\Torchlight::languageListOptions() }}
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
                                <div class="mb-4">
                                    <x-input-label for="background" value="Background color" />
                                    <label for="backgroundPicker" class="sr-only">Or enter color through your browser's color picker</label>
                                    <div class="flex flex-row justify-between w-48" id="backgroundColorContainer">
                                        <style>
                                            #backgroundColorContainer {
                                                position: relative;
                                                overflow: hidden;
                                                width: fit-content;
                                                height: fit-content;
                                                border-radius: .5rem;
                                            }
                                            #background {
                                                position: relative;
                                            }
                                            #background::-webkit-calendar-picker-indicator {
                                                /* Offset the datalist arrow */
                                                position: absolute;
                                                right: 3rem;
                                            }
                                            #backgroundPicker {
                                                position: absolute;
                                                right: -0.5rem;
                                                top: -0.5rem;
                                                height: 150%;
                                                width: 3.5rem
                                            }
                                        </style>

                                        <x-text-input type="text" id="background" name="background" value="{{ $background }}" list="colors" title="Enter a valid hexadecimal color code, or leave blank to use a transparent background" placeholder="#FFFFFF" class="w-48" />
                                        <input type="color" name="backgroundPicker" id="backgroundPicker" value="{{ $background === 'transparent' ? '#ffffff' : $background }}" class="h-auto bg-transparent cursor-pointer ml-2" />
                                    </div>
                                    <x-input-error :messages="$errors->get('background')" class="mt-2" />

                                    <datalist id="colors">
                                        <option value="transparent">Transparent</option>
                                        <option value="none">Transparent</option>
                                        <option value="#ffffff">White</option>
                                        <option value="#000000">Black</option>
                                        <option value="#f3f4f6">Gray</option>
                                    </datalist>
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="headerText" value="Header text" />
                                    <x-text-input id="headerText" name="headerText" type="text" value="{{ $headerText }}" class="w-48" />
                                    <x-input-error :messages="$errors->get('headerText')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="useHeader" value="Show menu bar" />
                                    <x-select-input id="useHeader" name="useHeader" class="w-48">
                                        <option value="true" {{ $useHeader === true ? 'selected' : ''}}>Use header menu</option>
                                        <option value="false" {{ $useHeader === false ? 'selected' : ''}}>No header menu</option>
                                    </x-select-input>
                                    <x-input-error :messages="$errors->get('useHeader')" class="mt-2" />
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
                    <div class="flex justify-center">
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

    <noscript><style>#backgroundPicker { display: none; }</style></noscript>

    <script>
        // Color picker interactivity

        const backgroundPicker = document.getElementById('backgroundPicker');
        const backgroundInput = document.getElementById('background');

        backgroundPicker.addEventListener('input', function () {
            backgroundInput.value = this.value;
        });

        backgroundInput.addEventListener('input', function () {
            reactToColorInputChange();
        });

        function reactToColorInputChange() {
            // Adds some UX normalization and reactivity to the color input
            // Obviously, we do a similar validation on the backend too.

            let value = backgroundInput.value;

            if (!value.startsWith('#')) {
                value = `#${value}`;
            }

            // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
            if (value.length === 4) {
                value = value.replace(/^#(.)(.)(.)$/, '#$1$1$2$2$3$3');
            }

            // If the value is a valid hex color
            if (/^#[0-9A-F]{6}$/i.test(value)) {
                backgroundPicker.value = value;
            }

            if (value === '#transparent' || value === '#none') {
                backgroundPicker.value = '#ffffff';
                backgroundPicker.style.opacity = '0.5';
            } else {
                backgroundPicker.style.opacity = '1';
            }
        }

        reactToColorInputChange();
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
                @if($background === 'transparent')
                backgroundColor: null, // Transparent background fix
                @endif
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
