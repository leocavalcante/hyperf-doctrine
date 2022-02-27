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

use Doctrine\DBAL\Driver\Connection as DoctrineConnection;
use Doctrine\DBAL\Driver\PDO\Result;
use Doctrine\DBAL\Driver\PDO\Statement;
use Doctrine\DBAL\Driver\Result as ResultInterface;
use Doctrine\DBAL\Driver\Statement as StatementInterface;
use Doctrine\DBAL\ParameterType;
use Hyperf\DB\DB;
use PDOStatement;

final class Connection implements DoctrineConnection
{
    private DB $connection;

    public function __construct(DB $connection)
    {
        $this->connection = $connection;
    }

    public function prepare(string $sql): StatementInterface
    {
        return new Statement($this->connection->prepare($sql));
    }

    public function query(string $sql): ResultInterface
    {
        /** @var PDOStatement $stmt */
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return new Result($stmt);
    }

    /**
     * @param string $value
     * @param int $type
     */
    public function quote($value, $type = ParameterType::STRING): string
    {
        return $this->connection->quote($value, $type);
    }

    public function exec(string $sql): int
    {
        return $this->connection->execute($sql);
    }

    public function lastInsertId($name = null): string
    {
        return $this->connection->lastInsertId($name);
    }

    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->connection->commit();
    }

    public function rollBack(): bool
    {
        return $this->connection->rollback();
    }
}
