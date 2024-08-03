<div>
    <label for="padding">Padding Size</label>
    <select id="padding" name="padding">
        <option value="small" {{ $padding === 'small' ? 'selected' : '' }}>Small</option>
        <option value="medium" {{ $padding === 'medium' ? 'selected' : '' }}>Medium</option>
        <option value="large" {{ $padding === 'large' ? 'selected' : '' }}>Large</option>
    </select>
</div>