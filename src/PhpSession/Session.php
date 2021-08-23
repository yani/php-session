<?php

declare(strict_types=1);

namespace Compwright\PhpSession;

class Session
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $contents = null;

    /**
     * @var bool
     */
    protected $writeable = true;

    /**
     * @var bool
     */
    protected $modified = false;

    public function __construct(string $name, string $id = null, array $contents = null)
    {
        $this->name = $name;

        if ($id) {
            $this->open($id, $contents);
        }
    }

    public function __get(string $name)
    {
        return $this->contents[$name] ?? null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->contents[$name]);
    }

    public function __set(string $name, $value)
    {
        if (!$this->writeable) {
            throw new \RuntimeException("Cannot alter session after it is closed");
        }

        $this->modified = true;
        $this->contents[$name] = $value;
    }

    public function __unset(string $name)
    {
        if (!$this->writeable) {
            throw new \RuntimeException("Cannot alter session after it is closed");
        }

        $this->modified = true;
        unset($this->contents[$name]);
    }

    public function open(string $id, array $contents = null)
    {
        $this->id = $id;
        $this->modified = false;
        $this->writeable = true;
        if (!is_null($contents)) {
            $this->setContents($contents);
        }
    }

    public function getName(): string
    {
        return $this->name ?? "";
    }

    public function getId(): string
    {
        return $this->id ?? "";
    }

    public function setContents(array $contents)
    {
        $this->contents = $contents;
    }

    public function isInitialized(): bool
    {
        return !is_null($this->contents);
    }

    public function isWriteable(): bool
    {
        return $this->writeable;
    }

    public function isModified(): bool
    {
        return $this->modified;
    }

    public function close()
    {
        $this->writeable = false;
    }

    public function toArray(): array
    {
        return $this->contents;
    }
}
