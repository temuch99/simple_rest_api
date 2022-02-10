<?php

namespace App\Models;

use App\DatabaseAdapters\MySQLAdapter;

abstract class Model
{
    /**
     * @var string
     */
    protected $selectAllQuery;

    /**
     * @var string
     */
    protected $selectById;

    /**
     * @var string
     */
    protected $insertRow;

    /**
     * @var string
     */
    protected $updateRow;

    /**
     * @var string
     */
    protected $deleteRow;

    /**
     * @return array
     */
    public function findAll(): array
    {
        $connection = MySQLAdapter::getInstance();

        $result = [];
        foreach ($connection->query($this->selectAllQuery) as $row) {
            $result[] = $row;
        }

        return $result;
    }

    /**
     * @var int $id
     *
     * @return array
     */
    public function find(int $id): array
    {
        $connection = MySQLAdapter::getInstance();

        $sth = $connection->prepare($this->selectById);
        $sth->execute(array("id" => $id));

        return $sth->fetch();
    }

    /**
     * @var array $values
     *
     * @return int
     */
    public function create(array $values): int
    {
        $connection = MySQLAdapter::getInstance();

        $sth = $connection->prepare($this->insertRow);
        return $sth->execute($values);
    }

    /**
     * @var array $values
     *
     * @return int
     */
    public function update(array $values): int
    {
        $connection = MySQLAdapter::getInstance();

        $sth = $connection->prepare($this->updateRow);
        return $sth->execute($values);
    }

    /**
     * @var int $id
     *
     * @return int
     */
    public function delete(int $id): int
    {
        $connection = MySQLAdapter::getInstance();

        $sth = $connection->prepare($this->deleteRow);
        $sth->execute(array("id" => $id));

        return $sth->fetch();
    }
}
