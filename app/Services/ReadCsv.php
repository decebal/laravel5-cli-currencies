<?php
/**
 * Created by PhpStorm.
 * User: decebal
 * Date: 28.01.2015
 * Time: 23:00
 */

namespace App\Services;


use Illuminate\Contracts\Filesystem\Filesystem;

class ReadCsv {

    public static function loadFromCsv(Filesystem $filesystem)
    {
        $fileLines = $filesystem->get('data.csv');
        var_dump($fileLines);
    }
}