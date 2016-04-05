<?
    class Cookie{
    public static function set( $name, $data ){
        setcookie( $name, $data, time() + 3600 * 24 * 30 ,'/');
    }

    public static function del( $name ){
        unset ($_COOKIE [$name]); 
        setcookie ($name, "", time() - 3600, '/');
    }

    public static function exist( $name ){
        if (isset( $_COOKIE[$name]))
            return true;
        return false;
    }

    public static function get( $name ){
        if ( ! empty ( $_COOKIE[ $name ] ) )
            return $_COOKIE[ $name ];
        return '';
    }
}