<?php

namespace App\Tests\unit\Services\Api\Artists;

use App\Services\Api\Artists\ArtistsClientProvider;
use PHPUnit\Framework\TestCase;

class ArtistsClientProviderTest extends TestCase
{
    public function testGetAllArtists()
    {
        $content = new ArtistsClientProvider('https://bboyrankingz.com/ranking/artists/'. date('Y') .'/elo.json');
        // Use one item
        $artist = array_values($content->getAllArtists()['artists'])[0];
        // Check if has change in output
        $this->assertArrayHasKey('title', $artist);
        $this->assertArrayHasKey('get_absolute_url', $artist);
        $this->assertArrayHasKey('country', $artist);
        $this->assertArrayHasKey('score', $artist);
        $this->assertArrayHasKey('max_score', $artist);
        $this->assertArrayHasKey('games', $artist);
        $this->assertArrayHasKey('date_max_score', $artist);
    }

}
