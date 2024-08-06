<section class="color-palette not-prose font-sans flex flex-row flex-wrap items-center w-fit p-2 gap-2 border border-gray-300">
    @foreach(\App\Helpers\ColorHelper::getBackgroundColors() as $name => $hex)
        <figure class="w-8 h-8 border border-gray-300 rounded-lg" style="background: {{ $hex }};" title="{{ \Hyde\Foundation\HydeKernel::makeTitle($name) }}"></figure>
    @endforeach
</section>
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