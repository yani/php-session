<?php

declare(strict_types=1);

namespace Compwright\PhpSession;

use SessionIdInterface;

class SessionId implements SessionIdInterface
{
    protected Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function __toString(): string
    {
        return $this->create_sid();
    }

    public function create_sid(): string
    {
        $length  = $this->config->getSidLength();
        $charset = $this->config->getSidCharset();
        $prefix  = $this->config->getSidPrefix();

        $lengthWithoutPrefix = $length - \strlen($prefix);

        $pieces = [];
        $max    = \strlen($charset) - 1;
        for ($i = 0; $i < $lengthWithoutPrefix; ++$i) {
            $pieces [] = $charset[\random_int(0, $max)];
        }

        return $prefix . \implode('', $pieces);
    }

    public function validate_sid(string $id): bool
    {
        if (\strlen($id) !== $this->config->getSidLength()) {
            return false;
        }

        $pregSafeString = \preg_quote($this->config->getSidCharset(), '/');

        return \preg_match('/^[' . $pregSafeString . ']+$/', $id) === 1;
    }
}
