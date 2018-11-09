<?php


namespace App\Presenters;
use Nette\Application\UI\Presenter;
use App\Forms\SignInForm;

class BasePresenter extends Presenter
{
    protected function createComponentSignInForm() {
        return (new SignInForm($this->user))->create();
    }

}