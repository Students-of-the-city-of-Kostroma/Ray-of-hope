<?php
class System{
    static function generate_hash($email){
        $secret="rayofhope_secret";
        $hash=md5($email.$secret);
        return $hash;
    }
}
?>