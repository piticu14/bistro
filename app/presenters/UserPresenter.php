<?php


namespace App\Presenters;

use App\Forms\SignUpForm;
use App\Forms\SignInForm;
use Nette;


class UserPresenter extends Nette\Application\UI\Presenter
{
    /**
     * @var Nette\Database\Context
     */
    private $database;


    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    protected function createComponentSignInForm() {
        return (new SignInForm($this->user))->create();
    }

    protected function createComponentSignUpForm() {
        return (new SignUpForm($this->database))->create();
    }

}