<?php
    $notification_DB = NotificationDb::getConnection();
    date_default_timezone_set("Asia/Colombo");

    class Notification{
        public $date= null;
        public $time = null;
        public $content = null;
        public $link = null;
        public $to = null;
        public $email = null;


        public function __construct($content,$link){
            $this->date = date("Y-m-d");
            $this->time = date("H:i:s");
            $this->content = $content;
            $this->link = $link;
        }
        public function set_to($to,$email){
            $this->to = $to;
            $this->email = $email;
        }
    }

    class Notification_DB_Query{
        private $notification_DB;
        
        public function send(Notification $notification){
            global $notification_DB;
            $query = "insert into user_notif_ic_" . $notification->to . " (Date, Time, Content, link) values ('" . $notification->date . "', '" . $notification->time . "', '" . $notification->content . "', '" . $notification->link . "');";
            if($notification_DB->query($query)){
                //echo $notification->to . " success<br/>";
            }else{
                //echo $notification->to . " Failed<br/>";
            }
        }
        public function send_mail(Notification $notification){
            $to_email = $notification->email;
            $subject = 'DCA updates';
            $message = $notification->content;
            $headers = 'From: kanthankanthan111@gmail.com';
            /*if(mail($to_email,$subject,$message,$headers)){
                //echo "mail sent";
            }*/
        }
    }

    class Notification_sender{
        private $_notifications = array();
        private $notification_DB;
        private $prototype_notification;
        private $mail;

        public function __construct($to,$content,$link,$mail){
            $this->prototype_notification = new Notification($content,$link);
            $this->mail=$mail;
            if($to=="all"){
                $this->set_all_users();
            }else{
                $this->set_to_some($to);
            }
            
        }

        public function add_users($user_nic,$email=null){
            $notification = clone $this->prototype_notification;
            $notification->set_to($user_nic,$email);
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
            if ($this->mail){
                global $con;
                while($con->more_results()){
                    $con->next_result();
                    $con->use_result();
                }
                $sql="SELECT NIC_num,email FROM `civilian_detail` WHERE NIC_num in ('".implode('\',\'',$to)."') ;";
                $result=$con->query($sql)->fetch_all();
                for($x=0; $x < count($result); $x++ ){
                    $this->add_users($result[$x][0],$result[$x][1]);
                }
            }
            else{
                foreach ($to as $user) {
                    $this->add_users($user);
                }
            }
        }

        public function send(){
            $sender = new Notification_DB_Query();
            array_walk($this->_notifications, array($sender, "send"));
            if ($this->mail){
                array_walk($this->_notifications, array($sender, "send_mail"));
            }
        }
    }

    /*sample code*/
    /*$sender = new Notification_sender("982812763V","you got an message", "/organization.php", true);
    $sender->send();*/