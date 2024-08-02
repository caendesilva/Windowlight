<div class="mb-4">
    <x-input-label for="language" value="Language" />
    <x-text-input id="language" name="language" type="text" list="languages" value="{{ $language }}" placeholder="php" class="w-48" />
    <x-input-error :messages="$errors->get('language')" class="mt-2" />
    <datalist id="languages">
        {{ \App\Contracts\Torchlight::languageListOptions() }}
    </datalist>
</div>