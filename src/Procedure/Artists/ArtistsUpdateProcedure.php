<?php

namespace App\Procedure\Artists;

use App\Entity\Artists;
use App\Services\Api\Artists\ArtistsClientProvider;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ArtistsUpdateProcedure
{
   private EntityManagerInterface $em;

   public function __construct(EntityManagerInterface $em)
   {
       $this->em = $em;
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


    public function flush($artists)
    {
        foreach ($artists as $artist) {
            $this->em->persist($artist);
            $this->em->flush();
        }
    }
}
