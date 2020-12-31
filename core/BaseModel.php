<?php

namespace app\core;

abstract class BaseModel
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    //public const RULE_REQUIRED = 'unique';

    //Va vérifier si les champs de data existent dans RegisterModel
    public function loadData($data)
    {
        foreach ($data as $key=>$value)
        {
            //Si la clé de data (Exemple: lastname) existe aussi dans le RegisterModel sous la forme $lastname
            if(property_exists($this,$key))
            {
                /*Alors $key vaut la value*/
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules():array;

    /**
     * Liste d'erreurs
     *
     * @var array
     */
    public $errors = [];

    public function validate()
    {
        foreach($this->rules() as $attribute =>$rules)
        {
            $value=$this->{$attribute};

            foreach($rules as $rule)
            {
                $ruleName=$rule;
                if(!is_string($ruleName))
                {
                    $ruleName=$rule[0];
                }
                //Si le nom de la règle vaut RULE_REQUIRED et que le champ est vide.
                if($ruleName === self::RULE_REQUIRED && !$value)
                {
                    //On envoie l'erreur avec le nom du champ et l'erreur en question
                    $this->addError($attribute,self::RULE_REQUIRED);
                }

                if($ruleName === self::RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL))
                {
                    //On envoie l'erreur avec le nom du champ et l'erreur en question
                    $this->addError($attribute,self::RULE_EMAIL);
                }

                if($ruleName === self::RULE_MIN && strlen($value)<$rule['min'])
                {
                    //On envoie l'erreur avec le nom du champ et l'erreur en question
                    $this->addError($attribute,self::RULE_MIN,$rule);
                }

                if($ruleName === self::RULE_MAX && strlen($value)>$rule['max'])
                {
                    //On envoie l'erreur avec le nom du champ et l'erreur en question
                    $this->addError($attribute,self::RULE_MAX,$rule);
                }
                //En gros si confirmPassword ($value ici) n'est pas égal à $this->{$rule['match']}, donc $password
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']})
                {
                    //On envoie l'erreur avec le nom du champ et l'erreur en question
                    $this->addError($attribute,self::RULE_MATCH,$rule);
                }
            }
        }
        return empty($this->errors);
    }

    public function addError(string $attribute,string $rule,$params=[])
    {
        $message=$this->errorMessages()[$rule]??'';
        foreach($params as $key =>$value)
        {
           $message=str_replace("{{$key}}",$value,$message); 
        }
        $this->errors[$attribute][]=$message;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED=>'This field is required',
            self::RULE_EMAIL=>'This field must be a valid email address',
            self::RULE_MIN=>'Min length of this field must be {min}',
            self::RULE_MAX=>'Min length of this field must be {max}',
            self::RULE_MATCH=>'This field must be the same as {match}',
        ];
    }
}