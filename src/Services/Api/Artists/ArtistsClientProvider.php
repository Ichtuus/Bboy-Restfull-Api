<?php

namespace App\Services\Api\Artists;

use App\Services\Api\Client\AbstractHttpClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;


class ArtistsClientProvider extends AbstractHttpClient
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function call()
    {
        return $this->getAllArtists();
    }

    public function getAllArtists()
    {
        $client = HttpClient::create();
        $content = $client->request('GET', $this->url)->toArray();

        // Check if we have any content and if exist other pages
        if ($content && $content['count']) {
            $nbOfPages = ceil($content['count'] / 10);
            $artistsExtracted = [];
            $request = [];

            if (empty($artistsExtracted)) {
                $pages = 0;
                for ($i = 0; $i < $nbOfPages; $i++) {
                    $pages += 1;
                    $request[$i] = $client->request('GET',  $this->url .'/?page='.$pages)->toArray();
                    foreach ($request[$i]['results'] as $item) {
                        $artistsExtracted[] = $item;
                    }
                }
            }
            return [
                'artists' => $artistsExtracted
            ];
        } else {
            return new JsonResponse([
                'error' => 'No data found'
            ]);
        }
    }
}
