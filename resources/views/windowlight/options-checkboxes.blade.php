<fieldset class="ml-4">
    <legend>
        <x-input-label>
            <strong>Options</strong>
        </x-input-label>
    </legend>
    <ul class="mt-1">
        @foreach([
            'lineNumbers' => 'Line numbers',
            'useHeader' => 'Show menu bar',
            'headerButtons' => 'Show menu buttons',
            'useShadow' => 'Background shadow'
        ] as $option => $label)
            <li class="mb-2">
                <label class="font-medium text-base text-gray-700 dark:text-gray-300 mb-1 inline-flex items-center cursor-pointer">
                    <span class="me-3">{{ $label }}</span>
                    <input type="checkbox" value="on" {{ $$option ? 'checked' : '' }} name="{{ $option }}" id="{{ $option }}" class="sr-only peer">
                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                </label>
                <x-input-error :messages="$errors->get($option)" class="mt-2" />
            </li>
        @endforeach
    </ul>
</fieldset>