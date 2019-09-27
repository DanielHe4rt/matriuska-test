<?php
/**
 * Created by PhpStorm.
 * User: Daniel Reis
 * Date: 26-Sep-19
 * Time: 21:16
 */

namespace App\Entities;


class Folder extends \ArrayObject
{
    public $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function load()
    {
        $directory = storage_path('app/Folders/' . $this->email . ".json");
        $folders = json_decode(file_get_contents($directory));
        $this->exchangeArray($folders);
    }
}
