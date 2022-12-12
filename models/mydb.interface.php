<?php

    declare(strict_types=1);

    namespace MyDB\Models;
    interface MyDBInterface
    {
        public function connectDB(...$loginData) : bool;
        public function closeDB() : bool;
        public function getFromDB(string $tableName, ...$values) : array|bool;
        public function addIndexToTable(string $tableName, ...$newIndexes) : array|bool;
    }