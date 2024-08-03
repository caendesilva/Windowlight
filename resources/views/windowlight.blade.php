<x-app-layout>
    <noscript>
        <style>#download, #backgroundPicker, .requires-javascript { display: none; }</style>
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
                                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Code input</h2>
                                </legend>
                                <div class="mb-4">
                                    <x-input-label for="code" value="Enter your code here" />
                                    <x-textarea class="block w-full" id="code" name="code" rows="8" required>{{ $input }}</x-textarea>
                                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                                </div>
                            </fieldset>

                            <fieldset class="w-full lg:w-1/2 px-4">
                                <legend class="mb-2">
                                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Settings</h2>
                                </legend>
                                <div class="flex flex-row flex-wrap space-x-4">
                                    <div>
                                        @include('windowlight.language-input')
                                        @include('windowlight.header-text-input')
                                        @include('windowlight.background-color-input')
                                    </div>

                                    <div>
                                        @include('windowlight.padding-input')
                                        @include('windowlight.options-checkboxes')
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <footer class="text-right">
                            <x-primary-button type="submit">{{ __('Generate') }}</x-primary-button>
                        </footer>
                    </form>
                </div>
            </section>
        </main>

        @if($result)
            @include('windowlight.result-section')
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            @include('footer')
        </div>
    </div>

    @if($generated)
        <script>
            const useResultScroll = true;
            if (useResultScroll) {
                document.getElementById('result-section').scrollIntoView();
            }
        </script>
    @endif

    <script>
        const textarea = document.querySelector('textarea');
        const useAutofocus = false;

        @if(! $generated)
        if (useAutofocus) {
            textarea.focus();
            textarea.setSelectionRange(textarea.value.length, textarea.value.length);
        }
        @endif
    </script>

    <script>
        const downloadButton = document.getElementById('download');
        downloadButton.addEventListener('click', render);

        function render() {
            const codeCard = document.getElementById('code-card-wrapper');
            htmlToImage.toPng(codeCard, {
                pixelRatio: 4,
                style: { resize: 'none' },
                @if($background === 'transparent')
                backgroundColor: null,
                @endif
            }).then(downloadImage);
        }

        function downloadImage(dataUrl) {
            const link = document.createElement('a');
            link.href = dataUrl;
            link.download = "windowlight-{{ substr($resultId, 0, 8) }}.png";
            link.click();
            link.remove();
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/html-to-image@1.11.11/dist/html-to-image.min.js"></script>
</x-app-layout>
