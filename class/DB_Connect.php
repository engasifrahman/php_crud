<?php
    class DB{
        private static $db_host = DB_Host;
        private static $db_user = DB_User;
        private static $db_pass = DB_Pass;
        private static $db_name = DB_Name;

        protected static function connection()
        {
            $connect = new mysqli(DB::$db_host, DB::$db_user, DB::$db_pass, DB::$db_name);

            if($connect->connect_error)
            {
                die('Error: '.$connect->connect_error);
            }

            //echo 'DB connect successfully';

            return $connect;
        }
    }