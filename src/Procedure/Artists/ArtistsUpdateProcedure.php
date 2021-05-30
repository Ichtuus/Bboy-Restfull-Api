<?php

namespace App\Procedure\Artists;

use App\Builder\Artists\ArtistsDirector;
use App\Services\Api\Artists\ArtistsClientProvider;
use Doctrine\ORM\EntityManagerInterface;

class ArtistsUpdateProcedure
{
   private EntityManagerInterface $em;
   private ArtistsDirector $artistsDirector;

   public function __construct(EntityManagerInterface $em, ArtistsDirector $artistsDirector)
   {
       $this->em = $em;
       $this->artistsDirector = $artistsDirector;
   }

    /**
     * @param $currentArtists
     * @return int|null
     * @throws \Exception
     */
    public function process($currentArtists) : int|null
    {
        $apiContent = new ArtistsClientProvider('https://bboyrankingz.com/ranking/artists/2020/elo.json');
        $apiItems = count($apiContent->getAllArtists()['artists']);
        $artists = null;
        if (empty($currentArtists)) {
            $artists = $this->update($apiContent->getAllArtists()['artists']);
        } elseif ($apiItems > count($currentArtists)) {
            $newArtists = array_diff($apiContent->getAllArtists()['artists'], $currentArtists);
            $artists = $this->update($newArtists);
        } else {
           throw new \Exception('They don\'t have any new artists');
        }
        $this->flush($artists);
        return count($artists);
    }

    /**
     * @param $artists
     * @return array
     */
    public function update($artists): array
    {
        return $this->artistsDirector->buildFromArray($artists);
    }


    public function flush($artists)
    {
        foreach ($artists as $artist) {
            $this->em->persist($artist);
            $this->em->flush();
        }
    }
}
