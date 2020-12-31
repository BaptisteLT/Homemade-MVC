<?php
namespace app\models;

use app\core\BaseModel;



class RegisterModel extends BaseModel
{
    /**
     *
     * @var string
     */
    public $firstname;
    /**
     *
     * @var string
     */
    public $lastname;
    /**
     *
     * @var string
     */
    public $email;
    /**
     *
     * @var string
     */
    public $password;
    /**
     *
     * @var string
     */
    public $confirmPassword;

    public function rules():array
    {
        return[
            'firstname'=>[self::RULE_REQUIRED],
            'lastname'=>[self::RULE_REQUIRED],
            'email'=>[self::RULE_REQUIRED, self::RULE_EMAIL],
            'password'=>[self::RULE_REQUIRED,[self::RULE_MIN,'min'=>8]],
            'confirmPassword'=>[self::RULE_REQUIRED,[self::RULE_MATCH,'match'=>'password']]
        ];
    }

    public function register()
    {
        echo "Creating new user";
    }

}