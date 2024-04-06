<x-app-layout :title="$page->title">
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <main id="content" class="mx-auto max-w-7xl py-16 px-8">
                @include('hyde::components.post.article')
            </main>
        </div>
    </div>
</x-app-layout>
