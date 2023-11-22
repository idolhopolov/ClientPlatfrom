<?php

namespace App\Tests\Functional;

use App\Tests\FixturesFactory\DoctrineModelFactory;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;

class FunctionalTestCase extends KernelTestCase
{
    protected DoctrineModelFactory|null $factory = null;
    protected EntityManager|null $entityManager;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->entityManager = $this->service('doctrine.orm.default_entity_manager');

        $this->factory = new DoctrineModelFactory(
            $this->entityManager, DoctrineModelFactory::DBNAME_TEST);
    }

    protected function tearDown(): void
    {
        /**
         * @var $cache CacheClearerInterface
         */
        $cache = self::getContainer()->get('cache.default_clearer');
        $cache->clear('');
        $this->service('doctrine.orm.default_entity_manager')->clear();
        $this->factory = null;
        parent::tearDown();
    }

    protected function service(string $serviceId): mixed
    {
        return self::getContainer()->get($serviceId);
    }
}