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
    public function index()
    {
        return view('feed-v0', [
            'rssData' => $this->getRSSData(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $rssData = $this->updateRssItemByGuid($item);
        echo '<pre>';
        // var_dump($_POST);
        // var_dump($request);
        var_dump($rssData->asXML()); die;
    }

    protected function updateRssItemByGuid(SimpleXMLElement $item) : ?SimpleXMLElement
    {
        $rssData = $this->getRSSData();
        foreach ($rssData->channel->item as $idx => $i0) {
            if ($i0->guid === $item->guid) {
                // $rssData->channel->item[ $idx ] = $item;
                $rssData->channel->item[$idx] = $rssData->addChild('item', (string) $item);
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
        if (is_file($file)) {
            $raw = file_get_contents($file);
            $rssData = new SimpleXMLElement($raw);
        }
        return $rssData;
    }
    protected function getRssItemByGuid(SimpleXMLElement $rssData, string $guid): ?SimpleXMLElement
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

}
