@foreach($posts ?? MarkdownPost::getLatestPosts() as $post)
    @include('hyde::components.article-excerpt')
@endforeach