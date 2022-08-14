<?php

namespace Src\core;

use PDO;
use Src\enums\MatchMode;

class Entity {

    protected string $selectedColumns = '*';

    public function __construct(

        protected ?PDO $dbc = null,
        protected string $table = ''

    ) {}

    public function select(string ...$columns) {

        $this->selectedColumns = implode(',', $columns);

        return $this;

    }

    public static function fromView(PDO $dbc, string $view):static {

        return new static($dbc, $view);

    }

    public function findAll() {

        $sql = 'SELECT '. $this->selectedColumns .' FROM '. $this->table;

        $stmt = $this->dbc->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();

    }

    private function find(array $columnsValues) {

        $condString = '';

        foreach ($columnsValues as $col => $val) {

            $condString .= $col . ' = :' . $col . ' AND ';

        }

        $sql = 'SELECT ' . $this->selectedColumns . ' FROM ' . $this->table .
        ' WHERE ' . rtrim($condString, ' AND ');

        return $this->dbc->prepare($sql);

    }

    public function findBy(array $columnsValues) {

        $stmt = $this->find($columnsValues);

        $stmt->execute($columnsValues);

        return $stmt->fetch();

    }

    public function findAllBy(array $columnsValues) {

        $stmt = $this->find($columnsValues);

        $stmt->execute($columnsValues);

        return $stmt->fetchAll();

    }

    public function findMatches(array $columns, string|array $lookingFor, MatchMode $mode) {

        is_array($lookingFor) ?: $lookingFor = array($lookingFor);

        $whereString = '';
        $toBind = [];

        foreach ($columns as $col) {

            foreach ($lookingFor as $item) {

                $whereString .= $col . " LIKE ? OR ";
                
                $toBind[] = MatchMode::from($mode->value)->appendWildcard($item);
                
            }
        }

        $sql = 'SELECT ' . $this->selectedColumns . ' FROM ' . $this->table . ' WHERE ' . rtrim($whereString, ' OR ');

        $stmt = $this->dbc->prepare($sql);

        $pos = 1;

        foreach ($toBind as $val) {
            
            $stmt->bindValue($pos, $val);
            $pos++;

        }
        
        $stmt->execute();

        return $stmt->fetchAll();

    }

    public function save(array $colsVals) {

        $colString = '';
        $prepareString = '';

        foreach ($colsVals as $col => $val) {

            $colString .= $col . ',';
            $prepareString .= ':' . $col . ',';

        }

        $sql = 'INSERT INTO ' . $this->table . ' (' . rtrim($colString, ',') .
        ') VALUES (' . rtrim($prepareString, ',') . ')';

        $stmt = $this->dbc->prepare($sql);

        $stmt->execute($colsVals);

    }

    public function updateBy(string $column, string $value, array $updateColsVals) {

        $setString = '';

        foreach ($updateColsVals as $col => $val) {

            $setString .= $col . ' = :' . $col . ',';

        }

        $sql = 'UPDATE ' . $this->table . ' SET ' . rtrim($setString, ',') .
        ' WHERE ' . $column . '=' . $value;

        $stmt = $this->dbc->prepare($sql);

        $stmt->execute($updateColsVals);

    }

    public function deleteBy(string $column, string $value) {

        $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $column . ' = :' . $column;

        $stmt = $this->dbc->prepare($sql);

        $stmt->execute([$column => $value]);

    }
}