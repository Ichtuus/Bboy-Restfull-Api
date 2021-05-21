<?php

namespace App\Services\Api\Client;

use App\Model\Artists\HttpClientInterface;

Abstract class AbstractHttpClient implements HttpClientInterface
{
    abstract public function call();
}
