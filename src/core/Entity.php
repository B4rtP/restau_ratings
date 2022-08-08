<?php

namespace Src\core;

use PDO;

class Entity {

    public function __construct(

        protected PDO $dbc,
        protected string $table

    ) {}

    public function findAll() {

        $sql = 'SELECT * FROM '. $this->table;

        $stmt = $this->dbc->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();

    }

    public static function fromView(PDO $dbc, string $table):static {

        return new static($dbc, $table);

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