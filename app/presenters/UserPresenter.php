<?php


namespace App\Presenters;

use App\Forms\SignUpForm;
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

    protected function createComponentSignUpForm() {
        return (new SignUpForm($this->database))->create();
    }

    public function actionLogout() {
        $this->user->logout();
        $this->redirect('Homepage:default');
    }

}