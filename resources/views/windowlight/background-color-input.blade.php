<div class="flex justify-between items-end">
    <x-input-label for="background" value="Background color" />
    <button type="button" id="colorPresetsToggle" class="requires-javascript text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100 relative mb-1" title="Choose preset color">
        <span class="sr-only">Choose preset color</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v14a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H4zm1 2h10a1 1 0 011 1v10a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1zm7 3a1 1 0 11-2 0 1 1 0 012 0zm-3 1a1 1 0 100 2 1 1 0 000-2zm-3 3a1 1 0 110 2 1 1 0 010-2zm7-4a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
        </svg>
    </button>
</div>
<div class="flex flex-row justify-between w-48" id="backgroundColorContainer">
    <style>
        #backgroundColorContainer {
            position: relative;
            overflow: hidden;
            width: fit-content;
            height: fit-content;
            border-radius: .5rem;
        }
        #backgroundInput {
            position: relative;
        }
        #backgroundInput::-webkit-calendar-picker-indicator {
            /* Offset the datalist arrow */
            position: absolute;
            right: 3rem;
        }
        #backgroundPicker {
            position: absolute;
            right: -0.5rem;
            top: -0.5rem;
            height: 150%;
            width: 3.5rem
        }
    </style>

    <x-text-input type="text" id="backgroundInput" name="background" value="{{ $background }}" list="colors" title="Enter a valid hexadecimal color code, or leave blank to use a transparent background" placeholder="#FFFFFF" class="w-48" />
    <input type="color" name="backgroundPicker" id="backgroundPicker" value="{{ $background === 'transparent' ? '#ffffff' : $background }}" class="h-auto bg-transparent cursor-pointer ml-2" />
</div>
<x-input-error :messages="$errors->get('background')" class="mt-2" />

<datalist id="colors">
    <option value="transparent">Transparent</option>
    <option value="none">Transparent</option>
    <option value="#ffffff">White</option>
    <option value="#000000">Black</option>
    <option value="#f3f4f6">Gray</option>
</datalist>

<!-- Color Presets Popover -->
<div id="colorPresetsPopover" class="hidden absolute bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg z-10">
    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-100">Color Presets</h3>
    <div id="colorPresets" class="grid grid-cols-5 gap-2">
        <!-- Color preset buttons will be dynamically added here -->
    </div>
</div>