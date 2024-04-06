<x-app-layout :title="$title">
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <main class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <article class="basic-prose mx-auto text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $markdown }}
                </article>
            </main>
        </div>
    </div>
</x-app-layout>
