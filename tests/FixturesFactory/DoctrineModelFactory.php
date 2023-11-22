<?php

namespace App\Tests\FixturesFactory;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use ReflectionClass;

final class DoctrineModelFactory
{
    public const DBNAME_TEST = 'dbname_test';

    private FactoryClientPlatform $factory;
    private EntityManager|null $entityManager;

    public function __construct(EntityManager|null $entityManager, string $dbName)
    {
        $this->factory = $this->setUpFactory($dbName);
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \ReflectionException
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(string $class, array $fields = []): mixed
    {
        $object = $this->factory->{$this->getFunctionName($class)}($fields);

        $this->entityManager->persist($object);
        $this->entityManager->flush();
        gc_enable();
        gc_collect_cycles();

        return $object;
    }

    /**
     * @throws \ReflectionException
     */
    private function getFunctionName(string $class): string
    {
        $className = (new ReflectionClass($class))->getShortName();

        return sprintf('create%s', ucfirst($className));
    }

    public function getConnection(): Connection
    {
        return $this->entityManager->getConnection();
    }

    public function setUpFactory(string $dbName): FactoryClientPlatform
    {
        if ($dbName === self::DBNAME_TEST) {
            return new FactoryClientPlatform();
        }

        throw new \UnexpectedValueException('Something wrong with factory');
    }
}