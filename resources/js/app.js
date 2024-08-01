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

        // Line numbers change
        const lineNumbers = document.getElementById('lineNumbers');
        const codeCard = document.getElementById('code-card');
        const lineNumbersInitialState = lineNumbers.checked;
        let hasNotifiedAboutLineNumbers = false;

        lineNumbers.addEventListener('change', function () {
            if (lineNumbersInitialState === false && hasNotifiedAboutLineNumbers === false) {
                toast('Please regenerate the image to see the line numbers.');
                hasNotifiedAboutLineNumbers = true;
            }
            codeCard.setAttribute('data-line-numbers', this.checked);
        });

        // Shadow change
        const useShadow = document.getElementById('useShadow');

        useShadow.addEventListener('change', function () {
            if (this.checked) {
                codeCard.classList.add('shadow-lg');
            } else {
                codeCard.classList.remove('shadow-lg');
            }
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

        // New feature: Indentation with TAB and SHIFT+TAB
        const TAB_SIZE = 4;

        function handleIndentation(e) {
            if (e.key === 'Tab') {
                e.preventDefault();

                const start = this.selectionStart;
                const end = this.selectionEnd;

                // Get selected text
                const selectedText = this.value.slice(start, end);

                // Create tab string based on TAB_SIZE
                const tabString = ' '.repeat(TAB_SIZE);

                // If there's a selection
                if (start !== end) {
                    const lines = selectedText.split('\n');
                    const indentedLines = lines.map(line =>
                        e.shiftKey ? line.replace(new RegExp(`^(${tabString}|\t)`, 'g'), '') : tabString + line
                    );

                    // Replace the selection with indented/deindented text
                    this.value = this.value.slice(0, start) + indentedLines.join('\n') + this.value.slice(end);

                    // Restore selection
                    this.selectionStart = start;
                    this.selectionEnd = start + indentedLines.join('\n').length;
                } else {
                    // If no selection, just insert spaces at cursor position
                    this.value = this.value.slice(0, start) + tabString + this.value.slice(end);
                    this.selectionStart = this.selectionEnd = start + TAB_SIZE;
                }
            }
        }

        // Add the indentation event listener to the textarea
        textarea.addEventListener('keydown', handleIndentation);
    });

    // Toast notification
    function toast(message) {
        // Remove existing toasts
        if (document.querySelector('.toast')) {
            document.querySelector('.toast').remove();
        }

        const template = `
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <span>${message}</span>
            <div class="timeout">
                <div class="progress-bar"></div>
            </div>
        </div>
        `;

        document.body.appendChild(document.createRange().createContextualFragment(template));

        const toast = document.querySelector('.toast');

        setTimeout(() => {toast.style.opacity = '0';}, 3000);
        setTimeout(() => {toast.remove();}, 3500);
    }
}
