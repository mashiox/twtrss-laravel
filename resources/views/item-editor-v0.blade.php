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
        <h1>Edit RSS Item {{ old('guid', $item->guid) }}</h1>
        @if (isset($item))
            <form action="/feed/{{ $item->guid }}" method="POST">
                @csrf
                @method('PUT')
                <div class="editor-field">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" style="width: 478px;" value="{{ old('title', $item->title) }}">
                    @error('title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                @php
                $pubDate = new \DateTime($item->pubDate);
                $pubDate0 = $pubDate->format('Y-m-d');
                $pubDate1 = $pubDate->format('H:i:s');
                @endphp
                <div class="editor-field">
                    <label for="pubDate">Publish Date:</label>
                    <input type="date" name="pubDate0" id="pubDate0" style="width: 239px;" value="{{ $pubDate0 }}">
                    <input type="time" name="pubDate1" id="pubDate1" style="width: 239px;" value="{{ $pubDate1 }}">
                    @error('link')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="editor-field">
                    <label for="author">Author:</label>
                    <input type="text" name="author" id="author" style="width: 478px;" value="{{ old('author', $item->author) }}">
                    @error('link')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="editor-field">
                    <label for="link">Link / URL:</label>
                    <input type="text" name="link" id="link" style="width: 478px;" value="{{ old('link', $item->link) }}">
                    @error('link')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="editor-field">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" style="width: 478px; height: 144px;">{{ old('description', $item->description) }}</textarea>
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
