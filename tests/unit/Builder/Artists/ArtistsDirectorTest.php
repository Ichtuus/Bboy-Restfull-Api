<?php

namespace App\Tests\unit\Builder\Artists;

use App\Builder\Artists\ArtistsDirector;
use PHPUnit\Framework\TestCase;

class ArtistsDirectorTest extends TestCase
{
    public function testBuildFromArray()
    {
        $builder = new ArtistsDirector();
        $artists = $builder->buildFromArray([
            [
                "title" => "luffy",
                "get_absolute_url" => "/bboys/luffy/",
                "country" => "KR",
                "thumbnail" => "https://graph.facebook.com/100001879072379/picture?type=large",
                "score" => 3120,
                "max_score" => 3120,
                "games" => 112,
                "date_max_score" => "2020-06-20T23:44:00"
            ]
        ]);

        foreach ($artists as $artist) {
            $this->assertSame('luffy', $artist->getArtistsName());
            $this->assertSame('KR', $artist->getCountry());
            $this->assertSame('https://graph.facebook.com/100001879072379/picture?type=large', $artist->getThumb());;
        }

    }

}
