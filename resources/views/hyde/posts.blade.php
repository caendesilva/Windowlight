<x-simple-layout :title="$page->title">
    <main id="content" class="mx-auto max-w-7xl py-12 px-8">
        <header class="lg:mb-12 xl:mb-16">
            <h1 class="text-3xl text-left leading-10 tracking-tight font-extrabold sm:leading-none mb-8 md:mb-12 md:text-center md:text-4xl text-gray-700 dark:text-gray-200">
                Latest Posts
            </h1>
        </header>

        <div id="post-feed" class="max-w-3xl mx-auto">
            @include('hyde::components.blog-post-feed')
        </div>
    </main>
</x-simple-layout>
