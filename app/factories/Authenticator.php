<?php


namespace App\Factories;

use Nette;
use Nette\Security;

class Authenticator implements Security\IAuthenticator
{

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }

    public function authenticate(array $credentials) {

        list ($username, $password) = $credentials;

        $user = $this->database->table('user')
            ->where('username',$username)->fetch();

        if(!$user) {
            throw new Security\AuthenticationException("Uživatelské jméno '$username' neexistuje",self::IDENTITY_NOT_FOUND);
        }

        if(!password_verify($password,$user->password)) {
            throw new Security\AuthenticationException('Vaše heslo je neplatné.',self::INVALID_CREDENTIAL);
        }
        /**
         * Todo: Activate user by email
         */

        /*
         * if(!user->active) {
         * throw new Securitz\AuthenticationException("Váš účet neni aktivní. Aktivujte ho pomoci emailu, kterého jste obdržel.",self::NOT_APPROVED);
         */

        return new Security\Identity($user->id,'',['username' => $user->username]);
    }

}