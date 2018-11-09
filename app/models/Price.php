<?php


namespace App\Models;


class Price extends Base
{
    protected $table = 'price';
    protected $primaryKey = 'id';

    public $id;
    public $product_id;
    public $size_id;
    public $price;

    protected $fillable = [
        'product_id',
        'size_id',
        'price'
    ];

    public function getByProduct($productId) {
        return $this->database->table($this->table)
            ->where('product_id = ?', $productId)
            ->fetchAll();
    }

}