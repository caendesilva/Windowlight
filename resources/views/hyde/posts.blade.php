<x-simple-layout :title="$page->title">
    <main id="content" class="mx-auto max-w-7xl py-8 px-8">
        <header class="lg:mb-12 xl:mb-16">
            <h1 class="text-3xl text-left leading-10 tracking-tight font-extrabold sm:leading-none mb-4 md:text-center md:text-4xl text-gray-700 dark:text-gray-200">
                Latest Blog Posts
            </h1>
            <p class="text-gray-600 dark:text-gray-400 text-base text-left leading-7 md:leading-8 md:text-center md:text-lg">
                Get tips and tricks on how to most efficiently use Windowlight to generate quality code screenshots.
            </p>
        </header>

        <div id="post-feed" class="max-w-3xl mx-auto">
            @include('hyde::components.blog-post-feed')
        </div>
    </main>
</x-simple-layout>
