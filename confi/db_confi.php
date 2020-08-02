<?php
    //error_reporting(0);
    class ConnectDb
    {
        private static $instance = null;
        private $con;

        private $host = "remotemysql.com";
        private $user = "kfm2yvoF5R";
        private $pass = "4vkzHfeBh6";
        private $name = "kfm2yvoF5R";

        private function __construct()
        {
            $this->con = mysqli_connect($this->host, $this->user, $this->pass) or header('location:/confi/error.php');
            mysqli_select_db($this->con, $this->name);
        }

        public static function getConnection()
        {
            if (!self::$instance) {
                self::$instance = new ConnectDb();
            }
            return self::$instance->con;
        }

        public static function close_con(){
            if (self::$instance) {
                self::$instance->con->close();
            }
        }
    }

    class NotificationDb
    {
        private static $instance = null;
        private $con;

        private $host = "remotemysql.com";
        private $user = "LlvvpTpgPp";
        private $pass = "t6rKpohvCB";
        private $name = "LlvvpTpgPp";

        private function __construct()
        {
            $this->con = mysqli_connect($this->host, $this->user, $this->pass) or header('location:/confi/error.php');
            mysqli_select_db($this->con, $this->name);
        }

        public static function getConnection()
        {
            if (!self::$instance) {
                self::$instance = new NotificationDb();
            }
            return self::$instance->con;
        }

        public static function close_con(){
            if (self::$instance) {
                self::$instance->con->close();
            }
        }
    }

    class OrgDb
    {
        private static $instance = null;
        private $con;

        private $host = "remotemysql.com";
        private $user = "LvFAfm4fFA";
        private $pass = "JGhOtcM4ez";
        private $name = "LvFAfm4fFA";

        private function __construct()
        {
            $this->con = mysqli_connect($this->host, $this->user, $this->pass) or header('location:/confi/error.php');
            mysqli_select_db($this->con, $this->name);
        }

        public static function getConnection()
        {
            if (!self::$instance) {
                self::$instance = new OrgDb();
            }
            return self::$instance->con;
        }

        public static function close_con(){
            if (self::$instance) {
                self::$instance->con->close();
            }
        }
    }

    $con = ConnectDB::getConnection();


    function shutdown()
    {
        /*global $con, $org_DB, $notification_DB;
        
        $con->close();
        $org_DB->close();
        $notification_DB->close();*/

        ConnectDB::close_con();
        NotificationDb::close_con();
        OrgDb::close_con();

        ob_end_flush();
    }
    register_shutdown_function('shutdown');

    function filt_inp($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function ready_input($input)
    {
        return strtolower(trim($input));
    }