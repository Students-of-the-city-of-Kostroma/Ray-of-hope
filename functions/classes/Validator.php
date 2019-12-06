<?php
class Validator {
    static function audit_check($INN){
        $ch = curl_init("https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Token 4a11d013ae5f87468fcc2950cd81ea7cbf6d4300'
        ));
        $str = '{' . '"query" : "' . $INN . '"}'; 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
        $result = curl_exec($ch);	
        curl_close($ch);
        $resultPHP = json_decode($result, true);	
        return (count($resultPHP['suggestions'])>0);
    }
    
    static function validate_email($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    static function validate_name($name){
        return (strlen($name) <= 100 && !preg_match('/[^a-zA-ZА-Яа-я0-9 ,-]/u', $name));
    }
    
    static function validate_password($password){
        return (strlen($password) >= 6 && strlen($password) <= 100 && !preg_match('/[^A-Za-z0-9,\\-]/', $password));
    }
    
    static function validate_inn($inn){
        if (preg_match('/\D/', $inn)) return false;
        $inn = (string) $inn;
        $len = strlen($inn);
        if ($len === 10) {
            return $inn[9] === (string) (((2 * $inn[0] + 4 * $inn[1] + 10 * $inn[2] + 
            3 * $inn[3] + 5 * $inn[4] +  9 * $inn[5] + 
            4 * $inn[6] + 6 * $inn[7] +  8 * $inn[8]) % 11) % 10);
        } 
        elseif ($len === 12) {
            $num10 = (string) (((7 * $inn[0] + 2 * $inn[1] + 4 * $inn[2] +
            10 * $inn[3] + 3 * $inn[4] + 5 * $inn[5] +
            9 * $inn[6] + 4 * $inn[7] + 6 * $inn[8] +
            8 * $inn[9]) % 11) % 10);
            $num11 = (string) (((3 * $inn[0] +  7 * $inn[1] + 2 * $inn[2] +
            4 * $inn[3] + 10 * $inn[4] + 3 * $inn[5] +
            5 * $inn[6] +  9 * $inn[7] + 4 * $inn[8] +
            6 * $inn[9] +  8 * $inn[10]) % 11) % 10);
            return $inn[11] === $num11 && $inn[10] === $num10;
        }
        return false;
    }
}
?>