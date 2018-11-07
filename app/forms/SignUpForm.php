<?php


namespace App\Forms;

use Nette;
use Nette\Application\UI;
use App\Models\User;

class SignUpForm extends UI\Control
{
    /**
     * @var Nette\Database\Context
     */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        parent::__construct();
        $this->database = $database;
    }

    public function create() {
        $form = new UI\Form();
        $form->addText('username', 'Uživatelské jméno:')
            ->setRequired('Zadejte uživatelské jméno')
            ->addRule(UI\FORM::LENGTH, 'Uživatelské jméno musí být dlouhý minimálně %d znaků a maximálně %d znaků',[4,30])
            ->addRule(UI\FORM::PATTERN,'Heslo může obsahovat pouze písma, čislice a znaky `-` a `_`','[\w-]+');
        $form->addPassword('password', 'Heslo:')
            ->setRequired('Zadejte heslo')
            ->addRule(UI\FORM::MIN_LENGTH,'Uživatelské jméno musí mít alespoň %d znaky',4);
        $form->addPassword('password_verify','Kontrolní heslo')
            ->setRequired('Zopakujte heslo')
            ->setOmitted()
            ->addRule(UI\FORM::EQUAL,'Hesla se neshodují',$form['password']);
        $form->addEmail('email','Email:')
            ->setRequired('Zadejte emailovou adresu')
            ->addRule(UI\FORM::EMAIL,'Zadejte spravnou emailovou adresu');
        $form->addText('firstname','Jméno:');
        $form->addText('lastname','Příjmení:');
        $form->addTextArea('address','Adresa:');
        $form->addText('city','Město:');
        $form->addText('psc', 'PSČ:')
            ->setRequired(false)
            ->addRule(UI\FORM::PATTERN, 'PSČ musí mít 5 číslic','\d{5}');
        $form->addText('phone','Telefon:')
            ->setRequired(false)
            ->addRule(UI\FORM::PATTERN, 'Telefonní číslo musí obsahovat 9 číslíc.','\d{9}');

        $form->addSubmit('send','Vytvořit');
        $form->onSuccess[] = [$this, 'signUpFormSubmitted'];

        return $form;

    }

    public function signUpFormSubmitted(UI\Form $form, \stdClass $values) {

        $user = new User($this->database);
        $values->password = password_hash($values->password, PASSWORD_ARGON2I);
        foreach($values as $key => $value) {
            $user->{$key} = $value;
        }
        $user->store();
        $this->redirect('User:signup');
    }

}