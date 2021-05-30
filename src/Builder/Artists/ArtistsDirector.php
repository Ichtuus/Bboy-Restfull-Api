<?php

namespace App\Builder\Artists;

use App\Entity\Artists;
use DateTime;

class ArtistsDirector
{

    public function buildFromArray(array $artists): array
    {
        $artistsList = [];
        foreach ($artists as $artist) {
            $Artists = new Artists();
            if (isset($artist['title'])) {
                $Artists->setArtistsName($artist['title']);
            }
            if (isset($artist['country'])) {
                $Artists->setCountry($artist['country']);
            }
            if (isset($artist['thumbnail'])) {
                $Artists->setThumb($artist['thumbnail']);
            }
            $Artists->setDateAdd(new DateTime());
            $artistsList[] = $Artists;
        }
        return $artistsList;
    }

}
