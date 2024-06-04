<?php

namespace App\Http\Controllers;

use \SimpleXMLElement;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $act = $request->query('a');
        $x = ($act === 'edit-feed');
        return view('feed-v1', [
            'rssData' => $this->getRSSData(),
            'active_feed' => $this->getRssFile(),
            'active_edit_feed' => $x,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('item-create-v0', [
            'item' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rssData = $this->getRSSData();
        if ('save-feed' == $_POST['a']) {
            $x = 1;
            $rssData->channel->title = $_POST['title'];
            $rssData->channel->link = $_POST['link'];
            $rssData->channel->description = $_POST['description'];
            $rssData->channel->managingEditor = $_POST['managingEditor'];
            $rssData->channel->webMaster = $_POST['webMaster'];
            $d0 = new \DateTime('now');
            $rssData->channel->pubDate = $d0->format(\DateTimeInterface::RSS);
            $rssData->channel->lastBuildDate = $rssData->channel->pubDate;
            $rssData->channel->generator = 'https://github.com/mashiox/twtrss-laravel';
            $rssData->channel->language = 'en-US';
            $this->setRSSData($rssData);
            return redirect('/feed');
        }

        // $item = $this->buildRSSItem($item);
        $item = $rssData->channel->addChild('item');
        $item->guid = _ulid();
        if (isset($_POST['guid'])) {
            $item0 = $this->getRssItemByGuid($rssData, $_POST['guid']);
            if (empty($item0)) {
                $item->guid = $_POST['guid'];
            } else {
                // @todo add session flash
                die('GUID is not unique [CFC-073]');
            }
        }
        $item->title = $_POST['title'];
        $item->link = $_POST['link'];
        $item->description = $_POST['description'];
        $item->author = $_POST['author'];
        $pubDate = new \DateTime($_POST['pubDate']);
        $item->pubDate = $pubDate->format(\DateTimeInterface::RSS);

        $this->setRSSData($rssData);
        return redirect('/feed');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  mixed  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $x = 1;
        //
        return view('item-editor-v0', [
            'item' => $this->getRssItemByGuid( $this->getRSSData(), $id ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $item = $this->getRssItemByGuid( $this->getRSSData(), $id );
        $item->title = $_POST['title'];
        $item->link = $_POST['link'];
        $item->description = $_POST['description'];
        $item->author = $_POST['author'];
        $pubDate = new \DateTime(sprintf('%s %s', $_POST['pubDate0'], $_POST['pubDate1']));
        $item->pubDate = $pubDate->format(\DateTimeInterface::RSS);

        $rssData = $this->updateRssItemByGuid($item);
        $this->setRSSData($rssData);
        return redirect('/feed');
    }

    protected function updateRssItemByGuid(SimpleXMLElement $item) : ?SimpleXMLElement
    {
        $rssData = $this->getRSSData();
        foreach ($rssData->channel->item as $idx => $i0) {
            if (0 === strcmp($i0->guid, $item->guid)) {
                $i0->title = $item->title;
                $i0->link = $item->link;
                $i0->description = $item->description;
                $i0->author = $item->author;
                $i0->pubDate = $item->pubDate;
            }
        }
        return $rssData;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function getRSSData() : ?SimpleXMLElement
    {
        $file = sprintf("%s/var/rss.xml", $_ENV['APP_ROOT']);
        $file = session('active-feed', $file);
        $file = $this->getRssFile();
        if (is_file($file)) {
            $raw = file_get_contents($file);
            $rssData = new SimpleXMLElement($raw);
        }
        return $rssData;
    }
    protected function getRssItemByGuid(SimpleXMLElement $rssData, string $guid) : ?SimpleXMLElement
    {
        // Loop through each item in the channel
        foreach ($rssData->channel->item as $item) {
            // Check if the item's guid matches the provided guid
            if (isset($item->guid) && (string) $item->guid === $guid) {
                // Return the matching item
                return $item;
            }
        }

        // No matching item found, return null
        return null;
    }
    protected function getRssFile()
    {
        $file = sprintf("%s/var/rss.xml", $_ENV['APP_ROOT']);
        $file = session('active-feed', $file);
        return $file;
    }

    protected function setRSSData(SimpleXMLElement $rssData) : bool
    {
        $file = sprintf("%s/var/rss.xml", $_ENV['APP_ROOT']);
        $file = session('active-feed', $file);
        $file = $this->getRssFile();
        return $rssData->asXML($file);
    }

    protected function buildRSSItem(string $id = null) : ?SimpleXMLElement
    {
        if ($id) {
            $item = $this->getRssItemByGuid( $this->getRSSData(), $id );
        } else {
            $item = new SimpleXMLElement;
            $item->id = _ulid();
        }
        $item->title = $_POST['title'];
        $item->link = $_POST['link'];
        $item->description = $_POST['description'];
        $item->author = $_POST['author'];
        if ($_POST['pubdate']) {
            $pubDate = new \DateTime($_POST['pubDate']);
            $pubDate = $pubDate->format(\DateTimeInterface::RSS);
        } else {
            $pubDate = new \DateTime(sprintf('%s %s', $_POST['pubDate0'], $_POST['pubDate1']));
            $pubDate = $pubDate->format(\DateTimeInterface::RSS);
        }
        $item->pubDate = $pubDate;
        return $item;
    }
}
