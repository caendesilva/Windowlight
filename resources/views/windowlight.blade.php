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
            @include('header')
        </div>

        <main class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <section class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('windowlight.store') }}">
                        @csrf

                        <div class="flex flex-col lg:flex-row -mx-4">
                            <fieldset class="w-full lg:w-1/2 xl:w-2/3 px-4">
                                <legend class="mb-2">
                                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                        Code input
                                    </h2>
                                </legend>
                                <div class="mb-4">
                                    <x-input-label for="code" value="Enter your code here" />
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
                                            <div id="color-presets" class="flex space-x-2 mt-2">
                                                <button type="button" class="w-6 h-6 rounded-full border border-gray-300" style="background-color: #FFFFFF;" title="White" data-color="#FFFFFF"></button>
                                                <button type="button" class="w-6 h-6 rounded-full border border-gray-300" style="background-color: #F3F4F6;" title="Light Gray" data-color="#F3F4F6"></button>
                                                <button type="button" class="w-6 h-6 rounded-full border border-gray-300" style="background-color: #1F2937;" title="Dark Gray" data-color="#1F2937"></button>
                                                <button type="button" class="w-6 h-6 rounded-full border border-gray-300" style="background-color: #111827;" title="Almost Black" data-color="#111827"></button>
                                                <button type="button" class="w-6 h-6 rounded-full border border-gray-300 bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500" title="Gradient" data-color="gradient"></button>
                                                <button type="button" class="w-6 h-6 rounded-full border border-gray-300" style="background-color: transparent;" title="Transparent" data-color="transparent">
                                                    <svg class="w-full h-full text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </button>
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
                                        <fieldset class="ml-4">
                                            <legend>
                                                <x-input-label>
                                                    <strong>Options</strong>
                                                </x-input-label>
                                            </legend>
                                            <ul class="mt-1">
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
                                                <li class="mb-2">
                                                    <label class="font-medium text-base text-gray-700 dark:text-gray-300 mb-1 inline-flex items-center cursor-pointer">
                                                        <span class="me-3 ">Background shadow</span>
                                                        <input type="checkbox" value="on" {{ $useShadow ? 'checked' : '' }} name="useShadow" id="useShadow" class="sr-only peer">
                                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                    </label>
                                                    <x-input-error :messages="$errors->get('useShadow')" class="mt-2" />
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
        </main>

        @if($result)
            <div id="result-section" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
                <section class="h-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <header class="flex flex-row flex-wrap items-center justify-between">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Code result
                        </h2>
                        <x-primary-button id="download">Download</x-primary-button>
                    </header>
                    <div class="flex justify-center my-4">
                        @include('windowlight.result')
                    </div>
                </section>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            @include('footer')
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
        const textarea = document.querySelector('textarea');

        const useAutofocus = false; // Disable autofocus for now

        @if(!$generated)
            if (useAutofocus) {
                // Move the cursor to the end of the textarea when the page loads
                textarea.focus(); // Experimental replacement for autofocus, while this breaks noscript, it makes so it only focuses on fresh page loads
                textarea.setSelectionRange(textarea.value.length, textarea.value.length);
            }
        @endif

    </script>

    <noscript><style>#backgroundPicker { display: none; }</style></noscript>

    <script>
        // Download the code screenshot

        const downloadButton = document.getElementById('download');

        downloadButton.addEventListener('click', function () {
            render();
        });

        function render() {
            const codeCard = document.getElementById('code-card-wrapper');

            htmlToImage.toPng(codeCard, {
                pixelRatio: 4, // Increase DPI (Resolution)
                style: {
                    resize: 'none', // Disable resize icon in the screenshot
                },
                @if($background === 'transparent')
                backgroundColor: null, // Transparent background fix
                @endif
            }).then(function (dataUrl) {
                downloadImage(dataUrl);
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

    <script defer src="https://cdn.jsdelivr.net/npm/html-to-image@1.11.11/dist/html-to-image.min.js"></script>
</x-app-layout>
