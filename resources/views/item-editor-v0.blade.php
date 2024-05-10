<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit RSS Item</title>
    <style>
        .editor-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 1rem;
        }
        .editor-field {
            margin-bottom: 1rem;
        }
        .editor-field label {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="editor-container">
        <h1>Edit RSS Item</h1>
        @if (isset($item))
            <form action="/feed/{{ $item->guid }}" method="POST">
                @csrf
                @method('PUT')
                <div class="editor-field">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $item->title) }}">
                    @error('title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="editor-field">
                    <label for="link">Link:</label>
                    <input type="url" name="link" id="link" value="{{ old('link', $item->link) }}">
                    @error('link')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="editor-field">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description">{{ old('description', $item->description) }}</textarea>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit">Update</button>
            </form>
        @else
            <p>Item not found.</p>
        @endif
    </div>
</body>
</html>
