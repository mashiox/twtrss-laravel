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
        <h1>Set RSS Feed</h1>
        <p>Active Feed: <a href="/feed">{{ $active_feed }}</a></p>
        <form action="/pick-feed" method="POST">
            @csrf
            <div class="editor-field">
                <label for="feed">Feed:</label>
                <select name="feed" id="feed" style="width: 478px;" value="{{ $active_feed }}">
                @foreach( $file_list as $file )
                    {{ $af = ($active_feed == $file); }}
                    @if ($af)
                    <option selected="selected" value="{{ $file }}">{{ $file }}</option>
                    @else
                    <option value="{{ $file }}">{{ $file }}</option>
                    @endif
                @endforeach
                </select>
                @error('title')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Set</button>
        </form>
    </div>
</body>
</html>
