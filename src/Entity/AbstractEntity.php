<?php

namespace Entity;

use Service\DatabaseTrait;

abstract class AbstractEntity
{
    use DatabaseTrait;

    /** @var $id */
    protected $id;

    /** @var \mysqli $mysqli */
    protected $mysqli;

    public function __construct()
    {
        $this->mysqli = static::connect();
    }

    public function save()
    {
        $tableName = $this->getTableName();

        $isNew = empty($this->id);
        if ($isNew) {
            $tableColumns = $this->getTableColumns();
            unset($tableColumns['id']);
            $tableColumnsKeys = implode(',', array_keys($tableColumns));

            $x = [];
            foreach ($tableColumns as $tableColumn => $entityProperty) {
                $x[$tableColumn] = "@$tableColumn";
            }
            $valuesPlaceholder = implode(', ', $x);

            $query = "INSERT INTO {$tableName} ({$tableColumnsKeys}) VALUES($valuesPlaceholder) ";

            foreach ($tableColumns as $tableColumn => $entityProperty) {
                $query = str_replace("@$tableColumn", empty($this->$entityProperty) ? "null" : "'{$this->$entityProperty}'", $query);
            }

            $this->mysqli->query($query) or die($this->mysqli->error);
            return;
        }

        $x = [];
        $tableColumns = $this->getTableColumns();

        foreach ($tableColumns as $tableColumn => $entityProperty) {
            $val = $this->$entityProperty;
            if (empty($val)) {
                $x[$tableColumn] = "$tableColumn = null";
            } else {
                $x[$tableColumn] = "$tableColumn = '$val'";
            }
        }
        $values = implode(', ', $x);

        $query = "UPDATE $tableName SET $values where id = '$this->id'";

        $this->mysqli->query($query) or die($this->mysqli->error);
    }

    public function delete()
    {
        $query = "DELETE FROM {$this->getTableName()} where id = '$this->id'";

        $this->mysqli->query($query) or die($this->mysqli->error);
    }

    public static function create(array $properties)
    {
        $entity = new static($properties);
        return $entity;
    }


    abstract protected function getTableName();

    abstract protected function getTableColumns(): array;

}