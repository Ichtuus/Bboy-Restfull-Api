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
            $nbOfArtistsInPage = ceil($content['count'] / 10);
            $artistsExtracted = [];
            $request = [];

            if (empty($artistsExtracted)) {
                $pages = 0;
                for ($i = 0; $i < $nbOfArtistsInPage; $i++) {
                    $pages += 1;
                    $request[$i] = $client->request('GET',  $this->url)->toArray();
                    array_merge((array)array_push($artistsExtracted, $request[$i]['results']));
                }
            }
            return [
                'artists' => $artistsExtracted
            ];
        } else {
            return new JsonResponse([
                'error' => 'No datas found'
            ]);
        }
    }
}
