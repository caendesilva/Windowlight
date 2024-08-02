{{-- windowlight/partials/result-section.blade.php --}}
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