<?php

class Validator{
    static function dqteateValidator($input){
        $pattern = "/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/";
        if($input == "En cours" || preg_match($pattern, $input)){
            return true;
        } else{
            return false;
        }
    }

    static function PhoneValidator($input){
        $pattern = "/^([06]|[07])\d{8}$/";
        if(preg_match($input, $pattern)){
            return true;
        } else {
            return false;
        }
    }

    static function isNotEmpty($input){
        if(isset($input) && !empty($input)){
            return true;
        } else{
            return false;
        }
    }
}