@dump(\App\Helpers\ColorHelper::generateColorScheme())
<div style="font-family: sans-serif;display: flex; flex-direction: row; align-items: center; width: fit-content; margin: 0.5rem; padding: 0.5rem; border: 1px solid gray">
    @foreach(\App\Helpers\ColorHelper::generateColorScheme() as $name => $hex)
        <figure style="background: {{ $hex }}; width: 4rem; height: 4rem; margin: 0.5rem; padding: 1rem; display: block; border: 1px solid gray;">
            <figcaption style="font-size: 1rem; margin: 0; padding: 0; text-align: center; display: flex; flex-direction: column; justify-content: space-between; height: 100%; width: 100%; {{ \App\Helpers\ColorHelper::isColorDark($hex) ? 'color: white;' : 'color: black;' }}">
                <header>{{ \Hyde\Foundation\HydeKernel::makeTitle($name) }}</header>
                <footer>{{ $hex }}</footer>
            </figcaption>
        </figure>
    @endforeach
</div>

<h4>Start hue: {{ \App\Helpers\ColorHelper::$HUE_OFFSET }}&deg;</h4>
