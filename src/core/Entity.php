<?php

namespace Src\core;

use PDO;

abstract class Entity {

    protected string $joinedTable;

    protected function __construct(

        protected PDO $dbc,
        protected string $table

    ) {}

    public function findAll() {

        $sql = 'SELECT * FROM '. $this->table;

        $stmt = $this->dbc->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();

    }

    public function findAllFromMatches(array $columns, string|array $lookingFor) {

        is_array($lookingFor) ?: $lookingFor = array($lookingFor);

        $whereString = '';
        $toBind = [];

        foreach ($columns as $col) {

            foreach ($lookingFor as $item) {

                $whereString .= $col . " LIKE ? OR ";
                
                $toBind[] = '%'.$item.'%';

            }
        }

        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . rtrim($whereString, ' OR ');

        $stmt = $this->dbc->prepare($sql);

        $pos = 1;

        foreach ($toBind as $val) {
            
            $stmt->bindValue($pos, $val);
            $pos++;

        }
        
        $stmt->execute();

        return $stmt->fetchAll();

    }

}