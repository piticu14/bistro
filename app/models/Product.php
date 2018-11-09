<?php


namespace App\Models;

use Nette;


class Product extends Base
{
    /**
     * @var Price
     */
    private $price;

    /**
     * @var Size
     *
     */
    private $size;

    public function __construct(Nette\Database\Context $database,Price $price, Size $size )
    {
        parent::__construct($database);
        $this->price = $price;
        $this->size = $size;

    }


    protected $table = 'product';
    protected $primaryKey = 'id';

    public $id;
    public $name;
    public $ingredients;
    public $type;
    public $image;

    protected $fillable = [
        'name',
        'ingredients',
        'type',
        'image'
    ];


    public function all()
    {

        $results = [];
        $rows = $this->database->table($this->table)->fetchPairs('id');
        foreach ($rows as $row) {
            $results[$row->type][] = $this->create($row);

        }

        return $results;
    }

    private function create($product) {
        $result = [];
        $prices = $this->price->getByProduct($product->id);

        $result['id'] = $product->id;
        $result['name'] = $product->name;
        $result['ingredients'] = $product->ingredients;
        $result['type'] = $product->type;
        $result['image'] = $product->image;

        foreach($prices as $price) {
            $result['price'][] = [
                'id' => $price->id,
                'price' => $price->price
            ];
                $size = $this->size->find($price->size_id);
                if($size) {
                    $result['size'][] = [
                        'name' => $size->name,
                        'value' => $size->value,
                    ];
                }
        }

        return $result;
    }


}