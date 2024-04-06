<x-simple-layout :title="$title">
    <main class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
        <article class="basic-prose mx-auto text-gray-800 dark:text-gray-200 leading-tight">
            {{ $markdown }}
        </article>
    </main>
</x-simple-layout>
