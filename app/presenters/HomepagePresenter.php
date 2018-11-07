<?php

namespace App\Presenters;

use Nette;
use App\Factories\ProductFactory;
use Nette\Utils\ArrayHash;
Use Nette\Http\Session;

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

    public function actionAddToCart($id, $quantity) {
        $product = $this->productFactory->get($id);
        $product['quantity'] = $quantity;
        $product['price'] *= $quantity;

        $session = $this->session->getSection('cart');

        $session->$id = $product;

        $this->redirect('Homepage:default');
    }

    public function actionDeleteCartProduct($id) {
        $session = $this->session->getSection('cart');
        unset($session->$id);

        $this->redirect('Homepage:default');
    }



}
