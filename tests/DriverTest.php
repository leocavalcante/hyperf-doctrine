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
namespace HyperfTest;

use Hyperf\Contract\ContainerInterface;
use Hyperf\DB\DB;
use Hyperf\Doctrine\Connection;
use Hyperf\Doctrine\Driver;
use Hyperf\Utils\ApplicationContext;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \Hyperf\Doctrine\Driver
 */
final class DriverTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private ContainerInterface $container;

    private DB $db;

    private Driver $driver;

    protected function setUp(): void
    {
        $this->container = \Mockery::mock(ContainerInterface::class);
        $this->db = \Mockery::mock(DB::class);

        $this->driver = new Driver();

        ApplicationContext::setContainer($this->container);
    }

    public function testConnect(): void
    {
        $this->container
            ->expects('make')
            ->andReturns($this->db);

        $actual = $this->driver->connect([]);

        self::assertInstanceOf(Connection::class, $actual);
    }
}
