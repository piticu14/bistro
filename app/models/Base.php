<?php


namespace App\Models;

use Nette;

abstract class Base
{
    protected $table;
    protected $primaryKey;


    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    /**
     * Insert new user
     * @return bool|int|Nette\Database\Table\ActiveRow
     */
    public function store() {
        if($this->hasTable()) {
            return $this->database->table($this->table)->insert($this->toArray());
        }
        return false;
    }

    /**
     * Update user data
     * @return int
     */
    public function patch() {
        if($this->hasTable() && $this->hasPrimaryKey())
        return $this->database
            ->table($this->table)
            ->update($this->toArray(), 'WHERE ' . $this->primaryKey . ' = ?', $this->id);
    }

    /**
     * Find user based on $id param
     * @param $id
     * @return Base|bool
     */

    public function find($id) {
        if($this->hasTable() && $this->hasPrimaryKey()) {
            $row = $this->database
                ->table($this->table)
                ->where($this->primaryKey,$id)
                ->fetch();

            if($row) {

                $model = new static($this->database);
                foreach ($row as $key => $value) {
                    $model->{$key} = $value;
                }
                return $model;
            }
        }

        return false;
    }

    /**
     * Convert fillable data from cass to array
     * @return array
     */
    private function toArray() {
        $data = [];
        foreach ($this->fillable as $key) {
            $data[$key] = $this->{$key};
        }
        return $data;
    }

    /**
     * Check if Model has table set
     * @return bool
     */
    private function hasTable() {
        return $this->table ? true :false;
    }

    /**
     * Check if Model has primaryKey set
     * @return bool
     */

    private function hasPrimaryKey() {
        return $this->primaryKey ? true : false;
    }

}