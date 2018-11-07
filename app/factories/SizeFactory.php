<?php

namespace App\Factories;

use Nette;

class SizeFactory
{

    /** @var Nette\Database\Context */
    private $database;

    protected static $table = 'size';

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    public function getSizes(){
        return $this->database->table(self::$table)->fetchPairs('id','value');
    }
}