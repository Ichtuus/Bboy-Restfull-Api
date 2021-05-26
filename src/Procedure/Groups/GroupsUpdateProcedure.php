<?php

namespace App\Procedure\Groups;

use App\Entity\Groups;
use App\Services\Api\Groups\GroupsClientProvider;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class GroupsUpdateProcedure
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $currentGroups
     * @return int|null
     * @throws \Exception
     */
    public function process($currentGroups) : int|null
    {
        $apiContent = new GroupsClientProvider( 'https://bboyrankingz.com/ranking/groups/2020/elo.json');
        $apiItems = count($apiContent->getAllGroups()['groups']);
        $groups = null;
        if (empty($currentGroups)) {
            $groups = $this->update($apiContent->getAllGroups()['groups']);
        } elseif ($apiItems > count($currentGroups)) {
            $newArtists = array_diff($apiContent->getAllGroups()['groups'], $currentGroups);
            $groups = $this->update($newArtists);
        } else {
            throw new \Exception('They don\'t have any new groups');
        }
        $this->flush($groups);
        return count($groups);
    }

    /**
     * @param $groups
     * @return array
     */
    public function update($groups): array
    {
        $groupList = [];
        foreach ($groups as $group) {
            $Group = new Groups();
            if (isset($group['title'])) {
                $Group->setTitle($group['title']);
            }
            if (isset($group['country'])) {
                $Group->setCountry($group['country']);
            }
            if (isset($group['thumbnail'])) {
                $Group->setThumb($group['thumbnail']);
            }
            $Group->setDateAdd(new DateTime());
            $groupList[] = $Group;
        }
        return $groupList;
    }


    public function flush($groups)
    {
        foreach ($groups as $group) {
            $this->em->persist($group);
            $this->em->flush();
        }
    }

}
