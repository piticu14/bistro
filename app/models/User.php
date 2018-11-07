<?php

namespace App\Models;

class User extends Base
{

    protected $table = 'user';
    protected $primaryKey = 'id';

    public $id;
    public $username;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $address;
    public $psc;
    public $city;
    public $phone;

    protected $fillable = [
        'username',
        'password',
        'email',
        'firstname',
        'lastname',
        'address',
        'psc',
        'city',
        'phone'
    ];


}