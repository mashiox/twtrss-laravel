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
        <h1>Latest Updates</h1>
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
                    <p>{{ $item->description }}</p>
                </div>
            @endforeach
        @else
            <p>No updates found.</p>
        @endif
    </div>
</body>
</html>
