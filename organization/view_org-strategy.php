<?php  
    public class Viewer{
        private $role;

        public function set_role($role){
            $this->role = $role;
        }

        public function get_role(){
            return $this->role;
        }

        public function display(){
            $this->role->show_option();
        }
    }


    public interface Role{
        public show_option();
    }

    public class Visitor implements Role{
        private $show_text;

        public function __construct(){
            $this->show_text =  "<div id=membership_btn_container>
                                    <form action=org_join_leave.php method=get>
                                        <button id=membership_btn type='submit' name=org_id value=".$_GET['selected_org'].">Join</button>
                                    </form>
                                </div>";
        }

        public function show_option(){
            echo $this->show_text;
        }
    }

    public class Member implements Role{
        private $show_text;

        public function __construct(){
            $this->show_text = "<div id=membership_btn_container>
                                    <form action=org_join_leave.php method=get>
                                        <button id=membership_btn type='submit' name=org_id value=".$_GET['selected_org'].">Leave</button>
                                    </form>
                                </div>";
        }

        public function show_option(){
            echo $this->show_text;
        }
    }

    public class Co_leader implements Role{
        private $show_text;

        public function __construct(){
            $this->show_text = "<div id=membership_btn_container>
                                    <form action=org_join_leave.php method=get>
                                        <button id=membership_btn type='submit' name=org_id value=".$_GET['selected_org'].">Leave</button>
                                    </form>
                                </div>

                                <div id=edit_btn_container >
                                    <form action=edit_org.php method=get>
                                        <button id=edit_btn type='submit' name=edit_detail value=".$_GET['selected_org'].">Edit</button>
                                    </form>
                                </div>";
        }

        public function show_option(){
            echo $this->show_text;
        }
    }

    public class Leader implements Role{
        private $show_text;

        public function __construct(){
            $this->show_text = "<div id=membership_btn_container>
                                    <form action=org_join_leave.php method=get>
                                        <button id=membership_btn type='submit' name=org_id value=".$_GET['selected_org'].">Leave</button>
                                    </form>
                                </div>

                                <div id=edit_btn_container >
                                    <form action=edit_org.php method=get>
                                        <button id=edit_btn type='submit' name=edit_detail value=".$_GET['selected_org'].">Edit</button>
                                    </form>
                                </div>";
        }

        public function show_option(){
            echo $this->show_text;
        }
    }

    

    if($text_role == "visiter"){
        $role = new Visitor();
    }elseif($text_role == "member"){
        $role = new Member();
    }($text_role == "co-leader"){
        $role = new C0_leader();
    }($text_role == "leader"){
        $role = new Leader();
    }

    $viewer = new Viewer();
    $viewer->set_role($role);

    $viewer->display();