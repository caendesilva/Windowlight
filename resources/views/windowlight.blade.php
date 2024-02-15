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
                    <p class="text-base text-gray-800 dark:text-gray-200">
                        <strong>
                            Windowlight is a simple wrapper for Torchlight, helping you to create beautiful code screenshots.
                        </strong>
                        <span class="block mt-1 text-sm">
                            Because your code screenshots deserve the same love as your documentation.
                        </span>
                    </p>
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
                                    <x-textarea class="block w-full" id="code" name="code" rows="8" required>{{ $input }}</x-textarea>
                                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                                </div>
                            </fieldset>

                            <fieldset class="w-full lg:w-1/2 px-4">
                                <legend class="mb-2">
                                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                        Settings
                                    </h2>
                                </legend>
                                <div class="flex flex-row flex-wrap space-x-4">
                                    <div>
                                        <div class="mb-4">
                                            <x-input-label for="language" value="Language" />
                                            <x-text-input id="language" name="language" type="text" list="languages" value="{{ $language }}" placeholder="php" class="w-48" />
                                            <x-input-error :messages="$errors->get('language')" class="mt-2" />
                                            <datalist id="languages">
                                                {{ \App\Contracts\Torchlight::languageListOptions() }}
                                            </datalist>
                                        </div>
                                        <div class="mb-4">
                                            <x-input-label for="headerText" value="Menu bar text" />
                                            <x-text-input id="headerText" name="headerText" type="text" value="{{ $headerText }}" placeholder="App\Windowlight.php" class="w-48" />
                                            <x-input-error :messages="$errors->get('headerText')" class="mt-2" />
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
                                                    #backgroundInput {
                                                        position: relative;
                                                    }
                                                    #backgroundInput::-webkit-calendar-picker-indicator {
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

                                                <x-text-input type="text" id="backgroundInput" name="background" value="{{ $background }}" list="colors" title="Enter a valid hexadecimal color code, or leave blank to use a transparent background" placeholder="#FFFFFF" class="w-48" />
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
                                    </div>

                                    <div>
                                        <fieldset>
                                            <legend>
                                                <x-input-label>
                                                    <strong>Options</strong>
                                                </x-input-label>
                                            </legend>
                                            <ul class="ml-4">
                                                <li class="mb-2">
                                                    <label class="font-medium text-base text-gray-700 dark:text-gray-300 mb-1 inline-flex items-center cursor-pointer">
                                                        <span class="me-3 ">Line numbers</span>
                                                        <input type="checkbox" value="on" {{ $lineNumbers ? 'checked' : '' }} name="lineNumbers" id="lineNumbers" class="sr-only peer">
                                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                    </label>
                                                    <x-input-error :messages="$errors->get('lineNumbers')" class="mt-2" />
                                                </li>
                                                <li class="mb-2">
                                                    <label class="font-medium text-base text-gray-700 dark:text-gray-300 mb-1 inline-flex items-center cursor-pointer">
                                                        <span class="me-3 ">Show menu bar</span>
                                                        <input type="checkbox" value="on" {{ $useHeader ? 'checked' : '' }} name="useHeader" id="useHeader" class="sr-only peer">
                                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                    </label>
                                                    <x-input-error :messages="$errors->get('useHeader')" class="mt-2" />
                                                </li>
                                                <li class="mb-2">
                                                    <label class="font-medium text-base text-gray-700 dark:text-gray-300 mb-1 inline-flex items-center cursor-pointer">
                                                        <span class="me-3 ">Show menu buttons</span>
                                                        <input type="checkbox" value="on" {{ $headerButtons ? 'checked' : '' }} name="headerButtons" id="headerButtons" class="sr-only peer">
                                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                    </label>
                                                    <x-input-error :messages="$errors->get('headerButtons')" class="mt-2" />
                                                </li>
                                            </ul>
                                        </fieldset>
                                    </div>
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
            <div id="result-section" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
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

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <footer class="px-6 mt-12 -mb-4 text-center">
                <p class="text-gray-800 dark:text-gray-200 leading-tight">
                    Built by <a href="https://twitter.com/CodeWithCaen" rel="author" class="text-indigo-700 dark:text-indigo-300 font-semibold">Caen De Silva</a>
                    using <b>Laravel</b>, <b>TailwindCSS</b>, and vanilla <b>JavaScript</b>.
                </p>
                <p class="text-gray-800 dark:text-gray-200 leading-tight mt-2">
                    Syntax highlighting beautifully provided by <a href="https://torchlight.dev" rel="nofollow noopener" class="text-indigo-700 dark:text-indigo-300 font-semibold">Torchlight</a>.
                </p>
                <p class="text-gray-800 dark:text-gray-200 leading-tight mt-2">
                    <small>
                        Copyright &copy; 2024 <a href="https://github.com/caendesilva" rel="author noopener" class="text-indigo-700 dark:text-indigo-300 font-semibold">Caen De Silva</a>
                        - Some rights reserved.
                        <br>
                        Source code available on <a href="https://github.com/caendesilva/Windowlight" rel="noopener" class="text-indigo-700 dark:text-indigo-300 font-semibold">GitHub</a>.
                    </small>
                </p>
            </footer>
        </div>
    </div>

    @if($generated)
        <script>
            const useResultScroll = true; // Control whether to scroll to the result section after generating the code

            if (useResultScroll) {
                // Experimental: Scroll to the result section
                document.getElementById('result-section').scrollIntoView();
            }
        </script>
    @endif

    <script>
        // Progressive textarea enhancements
        const textarea = document.querySelector('textarea');

        const useAutofocus = false; // Disable autofocus for now

        @if(!$generated)
            if (useAutofocus) {
                // Move the cursor to the end of the textarea when the page loads
                textarea.focus(); // Experimental replacement for autofocus, while this breaks noscript, it makes so it only focuses on fresh page loads
                textarea.setSelectionRange(textarea.value.length, textarea.value.length);
            }
        @endif

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
        const backgroundInput = document.getElementById('backgroundInput');
        const wrapper = document.getElementById('code-card-wrapper');

        backgroundPicker.addEventListener('input', function () {
            backgroundInput.value = this.value;

            updateBackgroundColor(this.value);
        });

        backgroundInput.addEventListener('input', function () {
            reactToColorInputChange();
        });

        function updateBackgroundColor(color) {
            // Reactive background color state change

            if (color === 'transparent' || color === 'none') {
                // Low priority known bug: When setting to transparent, the html2canvas options
                // need to be reinitialized if the page was not loaded with a transparent background
                wrapper.style.backgroundColor = 'transparent';
            } else {
                wrapper.style.backgroundColor = color;
            }
        }

        function reactToColorInputChange() {
            // Adds some UX normalization and reactivity to the color input
            // Obviously, we do a similar validation on the backend too.

            let value = backgroundInput.value;

            if (!value.startsWith('#') && (value.length === 6 || value.length === 3)) {
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

            if (value === 'transparent' || value === 'none') {
                backgroundPicker.value = '#ffffff';
                backgroundPicker.style.opacity = '0.5';
            } else {
                backgroundPicker.style.opacity = '1';
            }

            updateBackgroundColor(value);
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

    <script>
        // Selection dropdown reactivity

        // On show menu bar change
        const useHeader = document.getElementById('useHeader');
        const headerButtons = document.getElementById('headerButtons');
        const codeCardHeader = document.getElementById('code-card-header');

        useHeader.addEventListener('change', function () {
            // Low priority known issue: When setting to this to false, the Torchlight
            // <pre> element should regain its top border radius, and vice versa

            if (this.checked) {
                codeCardHeader.style.display = 'flex';
            } else {
                codeCardHeader.style.display = 'none';

                headerButtons.checked = false;
                headerButtons.dispatchEvent(new Event('change'));
            }
        });

        headerButtons.addEventListener('change', function () {
            if (this.checked) {
                codeCardHeader.querySelector('#header-buttons').style.display = 'revert';

                useHeader.checked = true;
                useHeader.dispatchEvent(new Event('change'));
            } else {
                codeCardHeader.querySelector('#header-buttons').style.display = 'none';
            }
        });

        // Header text change
        const headerText = document.getElementById('headerText');
        const headerTitle = document.querySelector('#code-card-header #header-title-text');

        headerText.addEventListener('input', function () {
            headerTitle.textContent = this.value;
        });
    </script>

    <script defer src="{{ asset('vendor/html2canvas.min.js') }}"></script>
</x-app-layout>
