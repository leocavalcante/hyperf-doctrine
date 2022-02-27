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

use Doctrine\DBAL\Driver\Exception;
use Hyperf\DB\DB;
use Hyperf\Doctrine\Connection;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PDOStatement;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \Hyperf\Doctrine\Connection
 */
final class ConnectionTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private DB $db;

    private PDOStatement $stmt;

    private Connection $conn;

    protected function setUp(): void
    {
        $this->db = \Mockery::mock(DB::class);
        $this->stmt = \Mockery::mock(PDOStatement::class);
        $this->conn = new Connection($this->db);
    }

    /**
     * @throws Exception
     */
    public function testPrepare(): void
    {
        $this->db
            ->expects('prepare')
            ->andReturns($this->stmt);

        $this->conn->prepare('select foo from bar where baz = qux');
    }

    /**
     * @throws Exception
     */
    public function testQuery(): void
    {
        $this->db
            ->expects('prepare')
            ->andReturns($this->stmt);

        $this->stmt
            ->expects('execute')
            ->andReturns(true);

        $this->conn->query('select foo from bar where baz = qux');
    }

    public function testQuote(): void
    {
        $this->db
            ->expects('quote')
            ->andReturns('bar');

        self::assertSame('bar', $this->conn->quote('foo'));
    }

    /**
     * @throws Exception
     */
    public function testExec(): void
    {
        $this->db
            ->expects('execute')
            ->with('test')
            ->andReturns(1);

        self::assertSame(1, $this->conn->exec('test'));
    }

    public function testLastInsertId(): void
    {
        $this->db
            ->expects('lastInsertId')
            ->andReturns('1');

        self::assertSame('1', $this->conn->lastInsertId());
    }

    /**
     * @throws Exception
     */
    public function testBeginTransaction(): void
    {
        $this->db
            ->expects('beginTransaction')
            ->andReturns(true);

        self::assertTrue($this->conn->beginTransaction());
    }

    /**
     * @throws Exception
     */
    public function testCommit(): void
    {
        $this->db
            ->expects('commit')
            ->andReturns(true);

        self::assertTrue($this->conn->commit());
    }

    /**
     * @throws Exception
     */
    public function testRollBack(): void
    {
        $this->db
            ->expects('rollback')
            ->andReturns(true);

        self::assertTrue($this->conn->rollback());
    }
}
