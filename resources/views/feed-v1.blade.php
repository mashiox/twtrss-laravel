<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Updates</title>
    <style>
        .feed-container {
            border: 1px solid #ddd;
            padding: 1rem;
        }
        .feed-item {
            margin-bottom: 1rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 1rem;
        }
        .feed-item a {
            text-decoration: none;
            color: #000;
        }
        .feed-item img {
            width: 100px;
            float: left;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="feed-container">
    <h4><a href="/pick-feed">Active Feed</a>: {{ $active_feed }}</h4>
    @if (($active_edit_feed))
    <a href="/feed">Close</a>
    <form action="/feed" method="POST">
        @csrf
        <div class="editor-field">
            <p>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" style="width: 478px;" value="{{ $rssData->channel->title }}">
            @error('title')
                <span class="error">{{ $message }}</span>
            @enderror
            </p>

            <p>
            <label for="link">Link:</label>
            <input type="text" name="link" id="link" style="width: 478px;" value="{{ $rssData->channel->link }}">
            @error('link')
                <span class="error">{{ $message }}</span>
            @enderror
            </p>

            <p>
            <label for="">Description:</label>
            <input type="text" name="description" id="description" style="width: 478px;" value="{{ $rssData->channel->description }}">
            @error('')
                <span class="error">{{ $message }}</span>
            @enderror
            </p>

            <p>
            <label for="managingEditor">Managing Editor:</label>
            <input type="text" name="managingEditor" id="managingEditor" style="width: 478px;" value="{{ $rssData->channel->managingEditor }}">
            @error('managingEditor')
                <span class="error">{{ $message }}</span>
            @enderror
            </p>

            <p>
            <label for="webMaster">Webmaster:</label>
            <input type="text" name="webMaster" id="webMaster" style="width: 478px;" value="{{ $rssData->channel->webMaster }}">
            @error('webMaster')
                <span class="error">{{ $message }}</span>
            @enderror
            </p>
        </div>
        <button type="submit" name="a" value="save-feed">Save</button>
    </form>
    @else
    <a href="/feed?a=edit-feed">Edit</a>
    <div class="editor-field">
        <p>
        <label for="title">Title:</label>
        <input disabled type="text" name="title" id="title" style="width: 478px;" value="{{ $rssData->channel->title }}">
        @error('title')
            <span class="error">{{ $message }}</span>
        @enderror
        </p>

        <p>
        <label for="link">Link:</label>
        <input disabled type="text" name="link" id="link" style="width: 478px;" value="{{ $rssData->channel->link }}">
        @error('link')
            <span class="error">{{ $message }}</span>
        @enderror
        </p>

        <p>
        <label for="">Description:</label>
        <input disabled type="text" name="description" id="description" style="width: 478px;" value="{{ $rssData->channel->description }}">
        @error('')
            <span class="error">{{ $message }}</span>
        @enderror
        </p>

        <p>
        <label for="managingEditor">Managing Editor:</label>
        <input disabled type="text" name="managingEditor" id="managingEditor" style="width: 478px;" value="{{ $rssData->channel->managingEditor }}">
        @error('managingEditor')
            <span class="error">{{ $message }}</span>
        @enderror
        </p>

        <p>
        <label for="webMaster">Webmaster:</label>
        <input disabled type="text" name="webMaster" id="webMaster" style="width: 478px;" value="{{ $rssData->channel->webMaster }}">
        @error('webMaster')
            <span class="error">{{ $message }}</span>
        @enderror
        </p>
    </div>
    @endif
</div>
<div class="feed-container">
        <h1>Latest Updates</h1>
        <a href="{{ route('feed.create') }}" class="btn btn-primary" style="align-self: flex-end;">&plus; Create</a>
        @if (isset($rssData) && !empty($rssData))
            @foreach ($rssData->channel->item as $item)
                <div class="feed-item">
                    @if (isset($item->enclosure) && isset($item->enclosure['url']))
                        <img src="{{ $item->enclosure['url'] }}" alt="{{ $item->title }}">
                    @endif
                    <h2>
                        <a href="{{ $item->link }}">{{ $item->title }}</a>
                        <a href="/feed/{{ $item->guid }}/edit" style="float: right; font-size: 0.8rem; margin-left: 5px;">Edit</a>
                    </h2>
                    @if (isset($item->author))
                    <span>by <i>{{ $item->author }}</i></span>
                    @endif
                    <p>{{ $item->description }}</p>
                </div>
            @endforeach
        @else
            <p>No updates found.</p>
        @endif
    </div>
</body>
</html>
`