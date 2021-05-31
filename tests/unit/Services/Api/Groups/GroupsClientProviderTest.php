<?php

namespace App\Tests\unit\Services\Api\Groups;

use App\Services\Api\Groups\GroupsClientProvider;
use PHPUnit\Framework\TestCase;

class GroupsClientProviderTest extends TestCase
{

    public function testGetAllArtists()
    {
        $content = new GroupsClientProvider('https://bboyrankingz.com/ranking/groups/'. date('Y') .'/elo.json');
        // Use one item
        $group = array_values($content->getAllGroups()['groups'])[0];
        // Check if has change in output
        $this->assertArrayHasKey('title', $group);
        $this->assertArrayHasKey('get_absolute_url', $group);
        $this->assertArrayHasKey('country', $group);
        $this->assertArrayHasKey('score', $group);
        $this->assertArrayHasKey('max_score', $group);
        $this->assertArrayHasKey('games', $group);
        $this->assertArrayHasKey('date_max_score', $group);
    }


}
