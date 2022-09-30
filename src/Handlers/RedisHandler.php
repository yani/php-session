<?php

declare(strict_types=1);

// phpcs:ignoreFile PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Compwright\PhpSession\Handlers;

use Compwright\PhpSession\Config;
use Compwright\PhpSession\SessionId;
use MatthiasMullie\Scrapbook\Adapters\Redis as RedisKeyValueStore;
use Redis;
use RuntimeException;

/**
 * Redis session store.
 */
class RedisHandler extends ScrapbookHandler
{
    private ?Redis $redis;

    public function __construct(Config $config)
    {
        $this->config = $config; // still required by SessionIdTrait
        $this->sid = new SessionId($config);

        if (!extension_loaded('redis')) {
            throw new RuntimeException('Missing redis extension');
        }
    }

    public function open($path, $name): bool
    {
        if (isset($this->redis)) {
            return false;
        }

        // Parse redis connection settings from save path
        $query = [];
        $config = parse_url($path);
        if (!empty($config['query'])) {
            parse_str($config['query'], $query);
        }
        
        $redis = new Redis();

        if (!$redis->connect($config['host'], (int) $config['port'])) {
            unset($redis);
            return false;
        }

        if (!$redis->select((int) $query['database'] ?? 0)) {
            $redis->close();
            unset($redis);
            return false;
        }

        $redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_NONE);

        $this->redis = $redis;
        $this->store = new RedisKeyValueStore($redis);
        return true;
    }

    public function close(): bool
    {
        $this->store = null;

        if (!isset($this->redis)) {
            return false;
        }

        $success = $this->redis->close();
        unset($this->redis);

        return $success;
    }
}
