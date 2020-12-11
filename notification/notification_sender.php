<?php
    $notification_DB = NotificationDb::getConnection();
    date_default_timezone_set("Asia/Colombo");

    class Notification{
        public $date= null;
        public $time = null;
        public $content = null;
        public $link = null;
        public $to = null;

        public function __construct($content,$link){
            $this->date = date("Y-m-d");
            $this->time = date("H:i:s");
            $this->content = $content;
            $this->link = $link;
        }
        public function set_to($to){
            $this->to = $to;
        }
    }

    class Notification_DB_Query{
        private $notification_DB;
        
        public function send(Notification $notification){
            global $notification_DB;
            $query = "insert into user_notif_ic_" . $notification->to . " (Date, Time, Content, link) values ('" . $notification->date . "', '" . $notification->time . "', '" . $notification->content . "', '" . $notification->link . "');";
            if($notification_DB->query($query)){
                echo $notification->to . " success<br/>";
            }else{
                echo $notification->to . " Failed<br/>";
            }
        }
    }

    class Notification_sender{
        private $_notifications = array();
        private $notification_DB;
        private $prototype_notification;

        public function __construct($to,$content,$link){
            $this->prototype_notification = new Notification($content,$link);
            if($to=="all"){
                $this->set_all_users();
            }else{
                $this->set_to_some($to);
            }
        }

        public function add_users($user_nic){
            $notification = clone $this->prototype_notification;
            $notification->set_to($user_nic);
            $this->_notifications[] = $notification;
        }

        private function set_all_users(){
            global $notification_DB;
            $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE='BASE TABLE'";
            $result= $notification_DB->query($query);
            if($result){
                while($row = $result->fetch_assoc()){
                    $row_arr=explode("_", $row['TABLE_NAME']);
                    $user = end($row_arr);
                    $this->add_users($user);
                }
            }
        }

        private function set_to_some($user_list_str){
            $to = explode(",", $user_list_str);
            foreach ($to as $user) {
                $this->add_users($user);
            }
        }

        public function send(){
            $sender = new Notification_DB_Query();
            array_walk($this->_notifications, array($sender, "send"));
        }
    }

    /*sample code*/
    /*$sender = new Notification_sender("982812763V","you got an message", "/organization.php");
    $sender->send();*/