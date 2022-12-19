<?php

namespace Compwright\PhpSession\BehaviorTest;

use Behat\Behat\Context\Context;
use Compwright\PhpSession\Config;
use Compwright\PhpSession\Handlers\Psr16Handler;
use Compwright\PhpSession\Handlers\ScrapbookHandler;
use Compwright\PhpSession\Handlers\FileHandler;
use Compwright\PhpSession\Handlers\RedisHandler;
use Compwright\PhpSession\Manager;
use Compwright\PhpSession\Session;
use PHPUnit\Framework\Assert;
use RuntimeException;
use SessionHandlerInterface;

/**
 * Defines application features from the specific context.
 */
class PersistenceContext implements Context
{
    private Config $config;

    private Manager $manager;

    private Session $session;

    private string $previousSessionId;

    /**
     * @Given session :handler stored at :location
     */
    public function sessionHandlerStoredAtLocation(string $handler, string $location): void
    {
        if ($handler !== 'redis') {
            $location = sys_get_temp_dir() . DIRECTORY_SEPARATOR . trim($location);
            if (!is_dir($location)) {
                mkdir($location, 0777, true);
            }
        }

        $this->config = new Config();

        $this->config->setSavePath($location);

        switch ($handler) {
            case 'kodus':
                $cache = new \Kodus\Cache\FileCache($location, $this->config->getGcMaxLifetime());
                $handler = new Psr16Handler($this->config, $cache);
                break;
            case 'scrapbook':
                $fs = new \League\Flysystem\Filesystem(
                    new \League\Flysystem\Local\LocalFilesystemAdapter($location, null, LOCK_EX)
                );
                $cache = new \MatthiasMullie\Scrapbook\Adapters\Flysystem($fs);
                $handler = new ScrapbookHandler($this->config, $cache);
                break;
            case 'redis':
                $this->config->setSavePath('tcp://localhost:6379?database=0');
                $handler = new RedisHandler($this->config);
                break;
            case 'file':
                $handler = new FileHandler($this->config);
                break;
            default:
                throw new RuntimeException('Not implemented: ' . $handler);
        }

        $this->config->setSaveHandler($handler);
    }

    /**
     * @Then new session is started
     */
    public function newSessionStarted(): void
    {
        $this->manager = new Manager($this->config);
        $isStarted = $this->manager->start();
        Assert::assertTrue($isStarted, 'Session failed to start');
        /** @var Session $session */
        $session = $this->manager->getCurrentSession();
        $this->session = $session;
    }

    /**
     * @Then session is writeable
     */
    public function sessionIsWriteable(): void
    {
        Assert::assertCount(0, $this->session);
        Assert::assertTrue($this->session->isWriteable(), 'Session not writeable');
        $this->session->foo = 'bar';
        Assert::assertCount(1, $this->session);
        Assert::assertTrue($this->session->isModified(), 'Session not modified');
    }

    /**
     * @Then session is saved and closed
     */
    public function sessionIsSavedAndClosed(): void
    {
        $this->previousSessionId = $this->session->getId();
        $isClosed = $this->manager->write_close();
        Assert::assertTrue($isClosed, 'Session save failed');
    }

    /**
     * @Then further session writes are not saved
     */
    public function furtherSessionWritesAreNotSaved(): void
    {
        Assert::assertFalse($this->session->isWriteable());

        try {
            $this->session->__set('bar', 'baz');
        } catch (RuntimeException $e) {
            // ignore
        } finally {
            Assert::assertFalse($this->session->__isset('bar'));
        }
    }

    /**
     * @Then previous session is started
     */
    public function previousSessionStarted(): void
    {
        /** @var SessionHandlerInterface $handler */
        $handler = $this->config->getSaveHandler();
        $handler->close();
        $this->manager = new Manager($this->config);
        $this->manager->id($this->previousSessionId);
        $isStarted = $this->manager->start();
        Assert::assertTrue($isStarted, 'Previous session failed to start');
        Assert::assertSame($this->previousSessionId, $this->manager->id());
        /** @var Session $session */
        $session = $this->manager->getCurrentSession();
        $this->session = $session;
    }

    /**
     * @Then session is readable
     */
    public function sessionIsReadable(): void
    {
        Assert::assertCount(1, $this->session);
        Assert::assertIsArray($this->session->toArray());
        Assert::assertTrue(isset($this->session->foo), 'Session data not persisted');
        Assert::assertSame('bar', $this->session->foo, 'Session data unexpected');
    }

    /**
     * @Then session can be reset
     */
    public function sessionCanBeReset(): void
    {
        $isReset = $this->manager->reset();
        Assert::assertTrue($isReset, 'Session reset failed');
        /** @var Session $session */
        $session = $this->manager->getCurrentSession();
        $this->session = $session;
        Assert::assertCount(1, $this->session);
    }

    /**
     * @Then session can be erased
     */
    public function sessionCanBeErased(): void
    {
        Assert::assertCount(1, $this->session);
        $isErased = $this->manager->unset();
        Assert::assertTrue($isErased, 'Session reset failed');
        Assert::assertCount(0, $this->session);
    }

    /**
     * @Then session can be deleted
     */
    public function sessionCanBeDeleted(): void
    {
        $isDeleted = $this->manager->destroy();
        Assert::assertTrue($isDeleted, 'Session delete failed');
        $isReset = $this->manager->reset();
        Assert::assertFalse($isReset, 'Session reset should not have succeeded');
    }
}
