<div class="form-row">
    <div class="form-group col-md-6">
        <label for="title">Title</label>
        <input
            type="text"
            name="title"
            id="title"
            value="{{ $entry->title }}"
            class="form-control @error('title') is-invalid @enderror"
            placeholder="entry's title"
            onkeyup="$('#friendly_url').val($(this).val().replace(/\s+/gi, '-'));">
        @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @if ($createUrl ?? false)
    <div class="form-group col-md-6">
        <label for="friendly_url">Friendly url</label>
        <input
            type="text"
            name="friendly_url"
            id="friendly_url"
            value="{{ $entry->friendly_url }}"
            class="form-control @error('friendly_url') is-invalid @enderror"
            placeholder="entry-about-something">
        @error('friendly_url')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    @else
        <div class="form-group col-md-6">
            <label for="friendly_url">Friendly url</label>
            <input
                type="text"
                value="{{ $entry->friendly_url }}"
                class="form-control"
                readonly>
        </div>
    @endif
</div>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="description">Description</label>
        <input
            type="text"
            name="description"
            id="description"
            value="{{ $entry->description }}"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="description">
        @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="content">Content</label>
        <textarea
            name="content"
            id="content"
            class="form-control @error('content') is-invalid @enderror"
            rows="3">{{ $entry->description }}</textarea>
        @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
