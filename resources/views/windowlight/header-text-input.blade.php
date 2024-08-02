<div class="mb-4">
    <x-input-label for="headerText" value="Menu bar text" />
    <x-text-input id="headerText" name="headerText" type="text" value="{{ $headerText }}" placeholder="App\Windowlight.php" class="w-48" />
    <x-input-error :messages="$errors->get('headerText')" class="mt-2" />
</div>