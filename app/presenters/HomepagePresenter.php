<?php

namespace App\Presenters;

use Nette;
use App\Factories\ProductFactory;
use Nette\Utils\ArrayHash;
Use Nette\Http\Session;
use App\Forms\SignInForm;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /** @var ProductFactory */
    private $productFactory;

    /** @var Session */
    private $session;


    public function __construct(ProductFactory $productFactory, Session $session){
        $this->productFactory = $productFactory;
        $this->session = $session;
    }

    public function renderDefault() {
        //$this->session->getSection('cart')->remove();
        $cartProducts = $this->getCartProducts();


        if(!empty($cartProducts)) {
            $this->template->cartProducts = ArrayHash::from($cartProducts);
        }

        $this->template->products = ArrayHash::from($this->productFactory->getAll());

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
        $product = $this->productFactory->get($priceId);
        $product['quantity'] = $quantity;
        $product['price'] *= $quantity;

        $session = $this->session->getSection('cart');

        $session->$priceId = $product;

        $this->redrawControl('cart');
    }

    public function handleDeleteCartProduct($id) {
        $session = $this->session->getSection('cart');
        unset($session->$id);

        $this->redrawControl('cart');
    }

    protected function createComponentSignInForm() {
        return (new SignInForm($this->user))->create();
    }




}
