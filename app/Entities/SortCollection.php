<?php
/**
 * Created by PhpStorm.
 * User: Daniel Reis
 * Date: 26-Sep-19
 * Time: 21:31
 */

namespace App\Entities;


class SortCollection
{
    public $emails;
    public $folders;

    public function __construct(string $email)
    {
        $this->emails = new Email($email);
        $this->folders = new Folder($email);
    }

    public function getResult(){


        return true;
    }



}
