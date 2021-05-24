<?php

namespace App\Procedure\Artists;

use App\Services\Api\Artists\ArtistsClientProvider;

class ArtistsUpdateProcedure
{
    public function process() {
        $api = new ArtistsClientProvider('https://bboyrankingz.com/ranking/artists/2020/elo.json');
        return $api->getAllArtists();
    }

    public function update() {

    }

}
