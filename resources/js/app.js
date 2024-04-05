import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// If on the homepage, we need to initialize the scripts
if (window.location.pathname === '/') {
    document.addEventListener('DOMContentLoaded', function() {
        // Color picker interactivity

        const backgroundPicker = document.getElementById('backgroundPicker');
        const backgroundInput = document.getElementById('backgroundInput');
        const wrapper = document.getElementById('code-card-wrapper');

        backgroundPicker.addEventListener('input', function () {
            backgroundInput.value = this.value;

            updateBackgroundColor(this.value);
        });

        backgroundInput.addEventListener('input', function () {
            reactToColorInputChange();
        });

        function updateBackgroundColor(color) {
            // Reactive background color state change

            if (color === 'transparent' || color === 'none') {
                // Low priority known bug: When setting to transparent, the html2canvas options
                // need to be reinitialized if the page was not loaded with a transparent background
                wrapper.style.backgroundColor = 'transparent';
            } else {
                wrapper.style.backgroundColor = color;
            }
        }

        function reactToColorInputChange() {
            // Adds some UX normalization and reactivity to the color input
            // Obviously, we do a similar validation on the backend too.

            let value = backgroundInput.value;

            if (!value.startsWith('#') && (value.length === 6 || value.length === 3)) {
                value = `#${value}`;
            }

            // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
            if (value.length === 4) {
                value = value.replace(/^#(.)(.)(.)$/, '#$1$1$2$2$3$3');
            }

            // If the value is a valid hex color
            if (/^#[0-9A-F]{6}$/i.test(value)) {
                backgroundPicker.value = value;
            }

            if (value === 'transparent' || value === 'none') {
                backgroundPicker.value = '#ffffff';
                backgroundPicker.style.opacity = '0.5';
            } else {
                backgroundPicker.style.opacity = '1';
            }

            updateBackgroundColor(value);
        }

        reactToColorInputChange();

        // Selection dropdown reactivity

        // On show menu bar change
        const useHeader = document.getElementById('useHeader');
        const headerButtons = document.getElementById('headerButtons');
        const codeCardHeader = document.getElementById('code-card-header');

        useHeader.addEventListener('change', function () {
            // Low priority known issue: When setting to this to false, the Torchlight
            // <pre> element should regain its top border radius, and vice versa

            if (this.checked) {
                codeCardHeader.style.display = 'flex';
            } else {
                codeCardHeader.style.display = 'none';

                headerButtons.checked = false;
                headerButtons.dispatchEvent(new Event('change'));
            }
        });

        headerButtons.addEventListener('change', function () {
            if (this.checked) {
                codeCardHeader.querySelector('#header-buttons').style.display = 'revert';

                useHeader.checked = true;
                useHeader.dispatchEvent(new Event('change'));
            } else {
                codeCardHeader.querySelector('#header-buttons').style.display = 'none';
            }
        });

        // Header text change
        const headerText = document.getElementById('headerText');
        const headerTitle = document.querySelector('#code-card-header #header-title-text');

        headerText.addEventListener('input', function () {
            headerTitle.textContent = this.value;
        });

        // Progressive textarea enhancements

        const textarea = document.querySelector('textarea');

        // When inside the form and using CMD/CTRL + Enter, submit the form
        textarea.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' && (event.metaKey || event.ctrlKey)) {
                event.preventDefault();
                this.form.submit();
            }
        });
    });
}
