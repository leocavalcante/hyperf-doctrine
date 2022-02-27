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
! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));

$container = require BASE_PATH . '/config/container.php';

Hyperf\Di\ClassLoader::init();

$em = $container->get(Doctrine\ORM\EntityManagerInterface::class);

return Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($em);
