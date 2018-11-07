<?php


namespace App\Factories;

use Nette;

class ProductFactory
{
    /** string */
    protected static $table = 'product';
    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    public function getAll() {
        $prices = $this->database->table('price');
        $results = [];

        foreach ($prices as $price) {
            $result = [];
            $productFound = array_search($price->product->id,array_column($results, 'id'));
            if(!$productFound && !is_int($productFound)){
                $result['id'] = $price->product->id;
                $result['name'] = $price->product->name;
                $result['ingredients'] = $price->product->ingredients;
                $result['type'] = $price->product->type;
                $result['price'][] = [
                    'id' => $price->id,
                  'price' => $price->price,
                ];
                if($result['type'] === 'pizza') {
                    $result['size'][] = [
                        'name' => $price->size->name,
                        'value' => $price->size->value
                    ];
                }
                $result['image'] = $price->product->image;
                $results[] = $result;
            } else {
                $results[$productFound]['price'][] = [
                    'id' => $price->id,
                    'price' => $price->price,
                    ];
                $results[$productFound]['size'][] = [
                    'name' => $price->size->name,
                    'value' => $price->size->value
                ];
            }

        }

        return $results;
    }

    public function get($id) {
        $result = [];
        $price = $this->database->table('price')->get($id);
        $result['price_id'] = $price->id;
        $result['name'] = $price->product->id .'. ' . $price->product->name;
        $result['price'] = $price->price;
        if($price->product->type === 'pizza') {
            $result['size'] = $price->size->name . ' (' .$price->size->value .' cm)';
        }

        return $result;
    }

}