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

use Doctrine\ORM\EntityManagerInterface;

class ConfigProvider
{
    /**
     * @return array<string, mixed>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                EntityManagerInterface::class => EntityManagerFactory::class,
            ],
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'Doctrine ORM Entity Manager configurations.',
                    'source' => __DIR__ . '/../publish/doctrine.php',
                    'destination' => BASE_PATH . '/config/autoload/doctrine.php',
                ],
                [
                    'id' => 'cli-config',
                    'description' => 'Doctrine Console Runner configurations.',
                    'source' => __DIR__ . '/../publish/cli-config.php',
                    'destination' => BASE_PATH . '/config/cli-config.php',
                ],
            ],
        ];
    }
}
