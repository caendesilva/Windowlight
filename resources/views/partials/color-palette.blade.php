<section class="color-palette font-sans flex flex-row items-center w-fit m-2 p-2 border border-gray-300">
    @foreach(\App\Helpers\ColorHelper::getBackgroundColors() as $name => $hex)
        <figure class="w-16 h-16 m-2 p-4 border border-gray-300" style="background: {{ $hex }};" title="{{ $name }}"></figure>
    @endforeach
</section>