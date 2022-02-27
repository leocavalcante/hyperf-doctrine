<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf Doctrine.
 *
 * @link     https://github.com/leocavalcante/hyperf-doctrine
 * @document https://github.com/leocavalcante/hyperf-doctrine/blob/main/README.md
 * @contact  @leocavalcante
 * @license  https://github.com/leocavalcante/hyperf-doctrine/blob/main/LICENSE
 */
namespace Hyperf\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class EntityManagerFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     */
    public function __invoke(ContainerInterface $container): EntityManagerInterface
    {
        /** @var ConfigInterface $config */
        $config = $container->get(ConfigInterface::class);

        /** @var array<string, mixed>|\Doctrine\DBAL\Connection $conn */
        $conn = $config->get('doctrine.connection');

        /** @var \Doctrine\ORM\Configuration $conf */
        $conf = $config->get('doctrine.config');

        return EntityManager::create($conn, $conf);
    }
}
