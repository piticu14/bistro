<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI;
class SignInForm extends UI\Control
{

    /**
     * @var Nette\Security\User
     */
    private $user;

    public function __construct(Nette\Security\User $user) {
        parent::__construct();
        $this->user = $user;
    }
    public function create() {
        $form = new UI\Form;
        $form->addText('username','Uživatelské jméno:')
            ->setRequired('Zadejte uživatelské jméno');
        $form->addPassword('password','Heslo: ')
            ->setRequired('Zadejte heslo');
        $form->addSubmit('send','Přihlásit');
        $form->onSuccess[] = [$this,'signInFormSubmitted'];

        return $form;
    }

    public function signInFormSubmitted(UI\Form $form,\stdClass $values) {
       $this->user->login($values->username,$values->password);

    }


}