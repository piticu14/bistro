<?php


namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Models\Size;

class AdminPresenter extends Nette\Application\UI\Presenter
{
    /** @var Size */
    private $size;

    public function __construct (Size $size) {
        $this->sizeFactory = $size;
    }


    public function createComponentAddProduct() {
        $products =[
            'pizza' => 'Pizza',
            'burger' => 'Burger'
        ];

        $sizes = $this->size->all();

        $form = new Form;
        $form->addText('name','Titulek:')
            ->setRequired('Zadejte titulek pizzy');
        $form->addTextArea('ingredients','Suroviny:');
        $form->addSelect('type','Typ produktu:',$products)
            ->setPrompt('Zvolte typ')
            ->setAttribute('onchange','showSize()')
            ->setRequired('Vyberte typ produktu');

        if(empty($sizes)) {
            $form->addText('price','Cena:')
                ->setRequired('Zadejte cenu');
        } else {
            $form->addGroup('Velikost a cena');
            foreach ($sizes as $key => $size) {
                $form->addCheckbox('size' . $key, $size. ' cm');
                $form->addText('price' . $key,'Cena ' . $size . ' cm')
                    ->setRequired('Zadejte cenu produktu');
            }
        }


        return $form;


    }

}