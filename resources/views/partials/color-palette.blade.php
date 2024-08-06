@php
    $colors = \App\Helpers\ColorHelper::getBackgroundColors();
    $totalColors = count($colors);
    $breakpoints = [
        'sm' => ['width' => 640, 'rows' => 3],
        'md' => ['width' => 768, 'rows' => 2],
        'lg' => ['width' => 1024, 'rows' => 1],
    ];
@endphp

<style>
    .color-palette-item {
        width: calc({{ 100 / ceil($totalColors / 3) }}% - 0.5rem);
        max-width: 4rem;
    }
    @media (min-width: 768px) {
        .color-palette-item {
            width: calc({{ 100 / ceil($totalColors / 2) }}% - 0.5rem);
            max-width: 6rem;
        }
    }
    @media (min-width: 1024px) {
        .color-palette-item {
            width: calc({{ 100 / $totalColors }}% - 0.5rem);
            max-width: 3rem;
        }
    }
</style>

<section class="color-palette not-prose font-sans flex flex-row flex-wrap lg:flex-nowrap items-center justify-center w-full p-2 gap-2 border border-gray-300">
    @foreach($colors as $name => $hex)
        <figure class="color-palette-item aspect-square border border-gray-300 rounded-lg" style="background: {{ $hex }};" title="{{ \Hyde\Foundation\HydeKernel::makeTitle($name) }}"></figure>
    @endforeach
</section>

<script>
    function adjustColorPalette() {
        const container = document.querySelector('.color-palette');
        const items = container.querySelectorAll('.color-palette-item');
        const containerWidth = container.offsetWidth;

        let itemsPerRow = Math.ceil({{ $totalColors }} / 3); // Default for mobile (3 rows)
        let maxWidth = '4rem';
        if (containerWidth >= 768) {
            itemsPerRow = Math.ceil({{ $totalColors }} / 2); // Medium screens (2 rows)
            maxWidth = '6rem';
        }
        if (containerWidth >= 1024) {
            itemsPerRow = {{ $totalColors }}; // Large screens (1 row)
            maxWidth = '3rem';
        }

        const itemWidth = `calc(${100 / itemsPerRow}% - 0.5rem)`;
        items.forEach(item => {
            item.style.width = itemWidth;
            item.style.maxWidth = maxWidth;
        });
    }

    window.addEventListener('load', adjustColorPalette);
    window.addEventListener('resize', adjustColorPalette);
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colorPalette = document.querySelector('.color-palette');
        if (!colorPalette) return;

        const figures = colorPalette.querySelectorAll('figure');

        figures.forEach(figure => {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = figure.title;
            tooltip.style.cssText = `
            visibility: hidden;
            position: absolute;
            bottom: 120%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            text-align: center;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.1s, visibility 0.1s;
            pointer-events: none;
            z-index: 10;
        `;

            const arrow = document.createElement('div');
            arrow.style.cssText = `
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        `;

            tooltip.appendChild(arrow);

            figure.style.position = 'relative';
            figure.appendChild(tooltip);

            figure.addEventListener('mouseenter', () => {
                tooltip.style.visibility = 'visible';
                tooltip.style.opacity = '1';
            });

            figure.addEventListener('mouseleave', () => {
                tooltip.style.visibility = 'hidden';
                tooltip.style.opacity = '0';
            });
        });
    });
</script>