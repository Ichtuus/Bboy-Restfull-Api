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

    public function process() {
        $apiContent = new ArtistsClientProvider('https://bboyrankingz.com/ranking/artists/2020/elo.json');
        return $apiContent->getAllArtists()['artists'];
    }

    public function update($artists) {
       $artistsList = [];
        foreach ($artists as $artist) {
            foreach ($artist as $item) {
                if (count($item)) {
                    $Artists = new Artists();
                    if (isset($item['title'])) {
                        $Artists->setArtistsName($item['title']);
                    }
                    if (isset($item['country'])) {
                        $Artists->setCountry($item['country']);
                    }
                    if (isset($item['thumbnail'])) {
                        $Artists->setThumb($item['thumbnail']);
                    }
                    $Artists->setDateAdd(new DateTime());
                    $artistsList[] = $Artists;
                }
            }
        }
        return $artistsList;
    }

    public function flush($artists) {
        foreach ($artists as $artist) {
            $this->em->persist($artist);
            $this->em->flush();
        }
    }
}
