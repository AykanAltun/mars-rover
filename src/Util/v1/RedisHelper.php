<?php
declare(strict_types=1);

namespace App\Util\v1;

use Exception;
use Redis;

class RedisHelper
{
    private Redis $redis;
    private string $host = 'redis';
    private int $port = 6379;

    public function hSet(string $key, string $hashKey, string $value): void
    {
        try {
            $this->connect();
            $this->redis->hSet($key, $hashKey, $value);
        } catch (Exception $exception) {
            // throw new Exception
        }
    }

    public function hGet(string $key, string $hashKey): string|bool
    {
        try {
            $this->connect();
            return $this->redis->hGet($key, $hashKey);
        } catch (Exception $exception) {
            // throw new Exception
        }
    }

    private function connect(): void
    {
        if (empty($this->redis) || $this->redis->ping() != '+PONG') {
            $this->redis = new Redis();
            $this->redis->connect($this->host, $this->port);
        }
    }
}
