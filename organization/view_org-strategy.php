<?php  
    class Viewer{
        private $role;

        public function set_role($role){
            $this->role = $role;
        }

        public function get_role(){
            return $this->role;
        }

        public function display(){
            $this->role->show_membership_button();
            $this->role->show_edit_button();
        }
    }


    abstract class Role{
        protected $join_text;
        protected $leave_text;
        protected $edit_text;

        public function __construct(){
            $this->join_text =  "<div id=membership_btn_container>
                                    <form action=org_join_leave.php method=get>
                                        <button id=membership_btn type='submit' name=org_id value=".$_GET['selected_org'].">Join</button>
                                    </form>
                                </div>";
            $this->leave_text = "<div id=membership_btn_container>
                                    <form action=org_join_leave.php method=get>
                                        <button id=membership_btn type='submit' name=org_id value=".$_GET['selected_org'].">Leave</button>
                                    </form>
                                </div>";
            $this->edit_text= "<div id=edit_btn_container >
                                    <form action=edit_org.php method=get>
                                        <button id=edit_btn type='submit' name=edit_detail value=".$_GET['selected_org'].">Edit</button>
                                    </form>
                                </div>";
        }
        abstract function show_membership_button();
        abstract function show_edit_button();
    }

    class Visitor extends Role{
        public function __construct(){
            parent::__construct();
                                
        }

        public function show_membership_button(){
            echo $this->join_text;
        }
        public function show_edit_button(){
            echo '';
        }
    }

    class Member extends Role{

        public function __construct(){
            parent::__construct();
        }

        public function show_membership_button(){
            echo $this->leave_text;
        }
        public function show_edit_button(){
            echo '';
        }
    }

    class Co_leader extends Role{

        public function __construct(){
            parent::__construct();
        }

        public function show_membership_button(){
            echo $this->leave_text;
        }
        public function show_edit_button(){
            echo $this->edit_text;
        }
    }

    class Leader extends Role{

        public function __construct(){
            parent::__construct();
        }

        public function show_membership_button(){
            echo $this->leave_text;
        }
        public function show_edit_button(){
            echo $this->edit_text;
        }
    }

    $text_role=$_GET['role'];
    if($text_role == "visitor"){
        $role = new Visitor();
    }elseif($text_role == "member"){
        $role = new Member();
    }elseif($text_role == "co-leader"){
        $role = new Co_leader();
    }elseif($text_role == "leader"){
        $role = new Leader();
    }

    $viewer = new Viewer();
    $viewer->set_role($role);

    $viewer->display(); 
?>