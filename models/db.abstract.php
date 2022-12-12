<?php

    namespace MyDB\Models;
    abstract class DBAbstract
    {
        private const ALL_ERRORS_NUMBER = ['NOTATION_ERROR', 'WARNING_ERROR', 'FATAL_ERROR'];
        protected function errorMessage(string $message, int $type) : void
        {
            if(!(file_exists(LOGS_PATH.'logs.txt'))) return;
            $errmsg = sprintf("[ %s ] - %s", self::ALL_ERRORS_NUMBER[--$type], $message);

            if($fileStream = fopen(LOGS_PATH.'logs.txt', 'a+'))
            {
                fwrite($fileStream, $errmsg.PHP_EOL);
            }

            echo nl2br($errmsg."\n");
            if($type === 2) die();
        }

        protected function getData(string $coreDataPath = '') : mixed
        {
            if(!(file_exists($coreDataPath))) $this->errorMessage('Plik rdzenia bazy danych nie istnieje!', 3);
            $result = '';
            
            if($fileStream = fopen($coreDataPath, 'a+'))
            {
                while(($dataLine = fgetc($fileStream)) !== false)
                {
                    $result .= $dataLine;
                }
                return json_decode($result, true);
            }
        }
    }