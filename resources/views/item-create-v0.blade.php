<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New RSS Item</title>
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
        <h1>Create New RSS Item</h1>
        <form action="/feed" method="POST">
            @csrf
            <div class="editor-field">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" style="width: 478px;" value="{{ old('title') }}">
                @error('title')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="editor-field">
                <label for="pubDate">Publish Date:</label>
                <input type="datetime-local" name="pubDate" id="pubDate" style="width: 478px;" value="{{ old('pubDate') }}">
                @error('pubDate')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="editor-field">
                <label for="author">Author:</label>
                <input type="text" name="author" id="author" style="width: 478px;" value="{{ old('author') }}">
                @error('author')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="editor-field">
                <label for="link">Link / URL:</label>
                <input type="text" name="link" id="link" style="width: 478px;" value="{{ old('link') }}">
                @error('link')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="editor-field">
                <label for="description">Description:</label>
                <textarea name="description" id="description" style="width: 478px; height: 144px;">{{ old('description') }}</textarea>
                @error('description')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit">Create</button>
        </form>
    </div>
</body>
</html>
