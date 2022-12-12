<?php

    declare(strict_types=1);
    
    namespace MyDB\Core;

    require(__DIR__.DIRECTORY_SEPARATOR.'config.php');

    use MyDB\Models\DBAbstract;
    use MyDB\Models\MyDBInterface;

    final class MyDB extends DBAbstract implements MyDBInterface
    {
        private bool $isLogged = false;
        private const DATA_CORE = DATA_PATH.'data.json';

        public function connectDB(...$loginData) : bool
        {
            $enteredData = array_values($loginData);
            $goodData = array_values($this->getData(self::DATA_CORE)['database'][0]);
            
            if($enteredData !== $goodData)
            {
                $this->errorMessage('Podano nieprawidłowe dane logowania do bazdy danych', 2);
                return false;
            }

            $this->isLogged = true;
            return true;
        }

        public function closeDB() : bool
        {
            if(!($this->isLogged))
            {
                $this->errorMessage('Nie możesz przerwać połączenia', 2);
                return false;
            }
            $this->isLogged = false;
            return true;
        }

        private function operateStrict(array $values, array &$result) : void
        {
            array_walk($result['FULL_TABLE'], function($elementValue, $elementKey) use($values, &$result){
                foreach($values as $searchedKey => $searchedValue)
                {
                    if(!array_key_exists($searchedKey, $elementValue))
                    {
                        $this->errorMessage('Index ['.$searchedKey.'] nie istnieje w strukturze elementów tablicy', 1);
                        continue 1;
                    }
                    switch(is_array($searchedValue))
                    {
                        case true:
                            foreach($searchedValue as $value)
                            {
                                if($elementValue[$searchedKey] === $value) $result['STRICT_TABLE'][] = $elementValue;
                            }
                            break;
                        case false:
                            if($elementValue[$searchedKey] === $searchedValue) $result['STRICT_TABLE'][] = $elementValue;
                            break;
                    }
                }
            });
        }

        public function getFromDB(string $tableName, ...$values) : array|bool
        {
            if($this->isLogged === false) return false;
            $gettedData = $this->getData(self::DATA_CORE);
            unset($gettedData['database']);

            if(!array_key_exists($tableName, $gettedData)) return false;

            $result = [
                'FULL_TABLE' => $gettedData[$tableName],
                'STRICT_TABLE' => []
            ];
            if(count($values) > 0)
            {
                $this->operateStrict($values, $result);
                return array_values(array_unique($result['STRICT_TABLE'], SORT_REGULAR));
            }
            return array_values($result['FULL_TABLE']);
        }

        public function addIndexToTable(string $tableName, ...$newIndexes) : array|bool
        {
            if($this->isLogged === false) return false;

            $gettedData = $this->getData(self::DATA_CORE);
            if(!array_key_exists($tableName, $gettedData)) return false;

            if(count($newIndexes) < 1)
            {
                errorMessage('Nie podano wartości do dodania', 2);
                return false;
            }

            foreach($newIndexes as $indexValue)
            {
                array_push($gettedData[$tableName], $indexValue);
            }
            if(!file_exists(self::DATA_CORE)) $this->errorMessage('Plik rdzenia bazy danych nie istnieje!', 3);
            if($fileStream = fopen(self::DATA_CORE, 'w+'))
            {
                print_r($gettedData);
                $jsonData = json_encode($gettedData);
                echo $jsonData;
                fwrite($fileStream, $jsonData);
            }

            return true;
        }
    }