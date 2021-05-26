<?php

namespace App\Services\Api\Groups;

use App\Services\Api\Client\AbstractHttpClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class GroupsClientProvider extends AbstractHttpClient
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function call()
    {
        return $this->getAllGroups();
    }

    public function getAllGroups()
    {
        $client = HttpClient::create();
        $content = $client->request('GET', $this->url)->toArray();

        if ($content && $content['count']) {
            $nbOfPages = ceil($content['count'] / 10);
            $groupsExtracted = [];
            $request = [];

            if (empty($groupsExtracted)) {
                $pages = 0;
                for ($i = 0; $i < $nbOfPages; $i++) {
                    $pages += 1;
                    $request[$i] = $client->request('GET',  $this->url .'/?page='.$pages)->toArray();
                    foreach ($request[$i]['results'] as $item) {
                        $groupsExtracted[] = $item;
                    }
                }
            }

            return [
                'groups' => $groupsExtracted,
            ];
        } else {
            return new JsonResponse([
                'error' => 'No data found',
            ]);
        }
    }
}
