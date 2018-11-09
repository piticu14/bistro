<?php

namespace App\Presenters;

use Nette;
use App\Models\Product;
use App\Models\Price;
use App\Models\Size;
use Nette\Utils\ArrayHash;
Use Nette\Http\Session;


final class HomepagePresenter extends BasePresenter
{
    /** @var Product */
    private $product;

    /**
     * @var Price
     */
    private $price;

    /**
     * @var Size
     */
    private $size;

    /** @var Session */
    private $session;


    public function __construct(
        Product $product,
        Price $price,
        Session $session,
        Size $size)
    {
        $this->product = $product;
        $this->session = $session;
        $this->price = $price;
        $this->size = $size;

    }

    public function renderDefault() {
        //$this->session->getSection('cart')->remove();
        $cartProducts = $this->getCartProducts();


        if(!empty($cartProducts)) {
            $this->template->cartProducts = ArrayHash::from($cartProducts);
        }

        $this->template->products = ArrayHash::from($this->product->all());

    }

    private function getCartProducts() {
        if($this->session->hasSection('cart')) {
            return $this->session->getSection('cart')->getIterator();
        }
        return [];
    }

    /**
     * Add product to the cart using Ajax
     * DON'T USE `$id` as parameter because it will take the route
     * parameter instead of ajax request
     * @param $priceId
     * @param $quantity
     */
    public function handleAddToCart($priceId, $quantity) {
        $price = $this->price->find($priceId);
        $size = $this->size->find($price->size_id);
        $product = $this->product->find($price->product_id);


        $product_array = [];
        $product_array['price_id'] = $priceId;
        $product_array['name'] = $product->name;
        $product_array['price'] = $price->price * $quantity;
        $product_array['quantity'] = $quantity;
        $product_array['size']['name'] = $size->name;
        $product_array['size']['value'] = $size->value;

        $session = $this->session->getSection('cart');

        $session->$priceId = $product_array;

        $this->redrawControl('cart');
    }

    public function handleDeleteCartProduct($id) {
        $session = $this->session->getSection('cart');
        unset($session->$id);

        $this->redrawControl('cart');
    }

}
