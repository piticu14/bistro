<?php


namespace App\Factories;

use Nette;

class ProductFactory
{
    /** string */
    protected static $table = 'product';
    /** @var Nette\Database\Context */
    private $database;

    /**
     * ProductFactory constructor.
     * @param Nette\Database\Context $database
     */
    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    /**
     * Get all products from database
     * @return array
     */
    public function getAll() {
        $prices = $this->database->table('price');
        $results = [];

        foreach ($prices as $price) {
            $type = $price->product->type;
            // Check if product already exists in array
            $productFound = $this->hasProduct($price->product->id,$results,$type);
            if(!$productFound && !is_int($productFound)){
                // if product not found in array then add it
                $results[$type][] = $this->addProduct($price);
            } else {
                // If product is in results[], it means that we have another size and price for it
                $results[$type][$productFound]['price'][] = [
                    'id' => $price->id,
                    'price' => $price->price,
                    ];
                $results[$type][$productFound]['size'][] = [
                    'name' => $price->size->name,
                    'value' => $price->size->value
                ];
            }

        }

        return $results;
    }

    /**
     * Add product to array and return it
     * @param $price
     * @return array
     */
    private function addProduct($price) {
        $result = [];

        $result['id'] = $price->product->id;
        $result['name'] = $price->product->name;
        $result['ingredients'] = $price->product->ingredients;
        $result['type'] = $price->product->type;
        $result['price'][] = [
            'id' => $price->id,
            'price' => $price->price,
        ];
        $result['image'] = $price->product->image;

        // If the product is pizza add `size`
        if($result['type'] === 'pizza') {
            $result['size'][] = [
                'name' => $price->size->name,
                'value' => $price->size->value
            ];
        }

        return $result;

    }

    /**
     * Check if product exists in $results array
     * @param $id
     * @param $results
     * @param $type
     * @return bool|mixed
     */
    private function hasProduct($id, $results,$type) {
        if (!empty($results[$type])) {
            return array_search($id,array_column($results[$type], 'id'));
        }

        return false;
    }

    /**
     * Get product based on $id
     * @param $id
     * @return array
     */
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