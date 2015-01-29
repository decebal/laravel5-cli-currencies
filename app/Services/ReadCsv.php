<?php
/**
 * Created by PhpStorm.
 * User: decebal
 * Date: 28.01.2015
 * Time: 23:00
 */

namespace App\Services;


use Illuminate\Support\Facades\Storage;

class ReadCsv {

    public function loadFromCsv()
    {
        Storage::disk('local')->get('');
    }
}