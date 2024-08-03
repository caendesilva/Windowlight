<div class="mb-4">
    <x-input-label for="padding" value="Padding Size" />
    <div class="relative">
        <select id="padding" name="padding" class="block appearance-none w-48 bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
            <option value="none" {{ $padding === 'none' ? 'selected' : '' }}>None</option>
            <option value="small" {{ $padding === 'small' ? 'selected' : '' }}>Small</option>
            <option value="medium" {{ $padding === 'medium' ? 'selected' : '' }}>Medium</option>
            <option value="large" {{ $padding === 'large' ? 'selected' : '' }}>Large</option>
            <option value="extra-large" {{ $padding === 'extra-large' ? 'selected' : '' }}>Extra Large</option>
        </select>
    </div>
    <x-input-error :messages="$errors->get('padding')" class="mt-2" />
</div>