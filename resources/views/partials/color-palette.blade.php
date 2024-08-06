<div class="font-sans flex flex-row items-center w-fit m-2 p-2 border border-gray-300">
    @foreach(\App\Helpers\ColorHelper::getBackgroundColors() as $name => $hex)
        <figure class="w-16 h-16 m-2 p-4 border border-gray-300" style="background: {{ $hex }};">
            <figcaption class="text-base m-0 p-0 text-center flex flex-col justify-between h-full w-full {{ \App\Helpers\ColorHelper::isColorDark($hex) ? 'text-white' : 'text-black' }}">
                <header>{{ $name }}</header>
                <footer>{{ $hex }}</footer>
            </figcaption>
        </figure>
    @endforeach
</div>