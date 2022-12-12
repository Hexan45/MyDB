<?php

    declare(strict_types=1);

    $root = dirname(__DIR__).DIRECTORY_SEPARATOR;
    if(!defined('DATA_PATH')) define('DATA_PATH', $root.'data'.DIRECTORY_SEPARATOR);
    if(!defined('LOGS_PATH')) define('LOGS_PATH', $root.'logs'.DIRECTORY_SEPARATOR);
    if(!defined('MODELS_PATH')) define('MODELS_PATH', $root.'models'.DIRECTORY_SEPARATOR);

    require(MODELS_PATH.'mydb.interface.php');
    require(MODELS_PATH.'db.abstract.php');