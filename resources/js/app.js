import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// If on the homepage, we need to initialize the scripts
if (window.location.pathname === '/') {
    // Todo: Add feature to send an API request to save state changes in the background? (Or we refactor to use LocalStorage instead of sessions)

    document.addEventListener('DOMContentLoaded', function() {
        // DOM element selections
        const backgroundPicker = document.getElementById('backgroundPicker');
        const backgroundInput = document.getElementById('backgroundInput');
        const wrapper = document.getElementById('code-card-wrapper');
        const colorPresets = document.getElementById('colorPresets');
        const colorPresetsToggle = document.getElementById('colorPresetsToggle');
        const colorPresetsPopover = document.getElementById('colorPresetsPopover');
        const useHeader = document.getElementById('useHeader');
        const headerButtons = document.getElementById('headerButtons');
        const codeCardHeader = document.getElementById('code-card-header');
        const headerText = document.getElementById('headerText');
        const headerTitle = document.querySelector('#code-card-header #header-title-text');
        const lineNumbers = document.getElementById('lineNumbers');
        const codeCard = document.getElementById('code-card');
        const useShadow = document.getElementById('useShadow');
        const textarea = document.querySelector('textarea');

        // Constants
        const TAB_SIZE = 4;
        const presetColors = [
            { name: 'White', color: '#FFFFFF' },
            { name: 'Light Gray', color: '#F3F4F6' },
            { name: 'Dark Gray', color: '#1F2937' },
            { name: 'Almost Black', color: '#111827' },
            { name: 'Blue', color: '#3B82F6' },
            { name: 'Green', color: '#10B981' },
            { name: 'Red', color: '#EF4444' },
            { name: 'Yellow', color: '#F59E0B' },
            { name: 'Purple', color: '#8B5CF6' },
            { name: 'Transparent', color: 'transparent' }
        ];

        // Initialization
        createColorPresetButtons();
        reactToColorInputChange();
        addToggleButtonTooltip();
        addTooltips();

        const lineNumbersInitialState = lineNumbers.checked;
        let hasNotifiedAboutLineNumbers = false;

        // Initialize selected state
        const initialColor = backgroundInput.value;
        const initialButton = colorPresets.querySelector(`button[data-color="${initialColor}"]`);
        if (initialButton) {
            initialButton.classList.add('ring-2', 'ring-blue-500');
        }

        // Event listeners
        backgroundPicker.addEventListener('input', function() {
            backgroundInput.value = this.value;
            updateBackgroundColor(this.value);
        });

        backgroundInput.addEventListener('input', function() {
            reactToColorInputChange();
        });

        colorPresets.addEventListener('click', function(e) {
            const button = e.target.closest('button');
            if (button) {
                const color = button.dataset.color;
                updateBackgroundColor(color);
                backgroundInput.value = color;
                backgroundPicker.value = color === 'transparent' ? '#ffffff' : color;
            }
        });

        colorPresetsToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const rect = colorPresetsToggle.getBoundingClientRect();
            colorPresetsPopover.style.top = `${rect.bottom + window.scrollY + 5}px`; // Added 5px for spacing
            colorPresetsPopover.style.left = `${rect.left + window.scrollX}px`;
            colorPresetsPopover.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!colorPresetsPopover.contains(e.target) && e.target !== colorPresetsToggle) {
                colorPresetsPopover.classList.add('hidden');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !colorPresetsPopover.classList.contains('hidden')) {
                colorPresetsPopover.classList.add('hidden');
            }
        });

        useHeader.addEventListener('change', function() {
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

        headerButtons.addEventListener('change', function() {
            if (this.checked) {
                codeCardHeader.querySelector('#header-buttons').style.display = 'revert';

                useHeader.checked = true;
                useHeader.dispatchEvent(new Event('change'));
            } else {
                codeCardHeader.querySelector('#header-buttons').style.display = 'none';
            }
        });

        headerText.addEventListener('input', function() {
            headerTitle.textContent = this.value;
        });

        lineNumbers.addEventListener('change', function() {
            if (lineNumbersInitialState === false && hasNotifiedAboutLineNumbers === false) {
                toast('Please regenerate the image to see the line numbers.');
                hasNotifiedAboutLineNumbers = true;
            }
            codeCard.setAttribute('data-line-numbers', this.checked);
        });

        useShadow.addEventListener('change', function() {
            if (this.checked) {
                codeCard.classList.add('shadow-lg');
            } else {
                codeCard.classList.remove('shadow-lg');
            }
        });

        const padding = document.getElementById('padding');
        const codeCardWrapper = document.getElementById('code-card-wrapper');

        padding.addEventListener('change', function() {
            codeCardWrapper.classList.remove('padding-none', 'padding-small', 'padding-medium', 'padding-large', 'padding-extra-large');
            codeCardWrapper.classList.add(`padding-${this.value}`);
        });

        textarea.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' && (event.metaKey || event.ctrlKey)) {
                event.preventDefault();
                this.form.submit();
            }
        });

        textarea.addEventListener('keydown', handleIndentation);

        // Functions
        function createColorPresetButtons() {
            colorPresets.innerHTML = ''; // Clear existing buttons
            presetColors.forEach(preset => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'w-8 h-8 rounded-full border border-gray-300 dark:border-gray-600';
                button.style.backgroundColor = preset.color;
                button.dataset.color = preset.color;
                button.title = preset.name;

                if (preset.color === 'transparent') {
                    button.innerHTML = `
            <svg class="w-full h-full text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          `;
                }

                colorPresets.appendChild(button);
            });
        }

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

        function addToggleButtonTooltip() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = 'Choose preset color';
            tooltip.style.cssText = `
        visibility: hidden;
        position: absolute;
        bottom: 140%;
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
        transition: opacity 0.1s;
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

            colorPresetsToggle.style.position = 'relative';
            colorPresetsToggle.appendChild(tooltip);

            colorPresetsToggle.addEventListener('mouseenter', () => {
                tooltip.style.visibility = 'visible';
                tooltip.style.opacity = '1';
            });

            colorPresetsToggle.addEventListener('mouseleave', () => {
                tooltip.style.visibility = 'hidden';
                tooltip.style.opacity = '0';
            });
        }

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

        function addTooltips() {
            const buttons = colorPresets.querySelectorAll('button');
            buttons.forEach(button => {
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.textContent = button.title;
                tooltip.style.cssText = `
          visibility: hidden;
          position: absolute;
          bottom: 140%;
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
          transition: opacity 0.1s;
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

                button.style.position = 'relative';
                button.appendChild(tooltip);

                button.addEventListener('mouseenter', () => {
                    tooltip.style.visibility = 'visible';
                    tooltip.style.opacity = '1';
                });

                button.addEventListener('mouseleave', () => {
                    tooltip.style.visibility = 'hidden';
                    tooltip.style.opacity = '0';
                });
            });
        }
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
