<?php


namespace App\Models;


class Size extends Base
{

    protected $table = 'size';
    protected $primaryKey = 'id';


    public $id;
    public $name;
    public $value;

    protected $fillable = [
        'name',
        'value',
    ];

    public function all() {
        return $this->database->table($this->table)->fetchAll();
    }
}