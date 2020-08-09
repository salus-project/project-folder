<?php  
    class Viewer{
        private $role;

        public function set_role($role){
            $this->role = $role;
        }

        public function get_role(){
            return $this->role;
        }
        public function show_membership_button(){
            $this->role->show_membership_button();
        }
        public function show_edit_button(){
            $this->role->show_edit_button();
        }
        public function show_coleader_option($nic){
            $this->role->show_coleader_option($nic);
        }
        public function show_member_option($nic){
            $this->role->show_member_option($nic);
        }
        public function change_profile_option(){
            $this->role->change_profile_option();
        }
        public function change_coverphoto_option(){
            $this->role->change_coverphoto_option();
        }
    }


    abstract class Role{
        protected $join_text;
        protected $leave_text;
        protected $edit_text;
        protected $coleader_text;
        protected $profile_text;
        protected $cover_photo_text;

        public function __construct(){
            $this->join_text =  "<div id=membership_btn_container>
                                    <form action=org_join_leave.php method=get>
                                        <button id=membership_btn type='submit' name=org_id value=".$_GET['selected_org']."><i class='fa fa-handshake-o' aria-hidden='true'></i>Join</button>
                                    </form>
                                </div>";
            $this->leave_text = "<div id=membership_btn_container>
                                    <form action=org_join_leave.php method=get>
                                        <button id=membership_btn type='submit' name=org_id value=".$_GET['selected_org']."><i class='fa fa-share-square-o' aria-hidden='true'></i></i>Leave</button>
                                    </form>
                                </div>";
            $this->edit_text= "<div id=edit_btn_container >
                                    <form action=edit_org.php method=get>
                                        <button id=edit_btn type='submit' name=org_id value=".$_GET['selected_org']."><i class='fa fa-pencil-square-o' aria-hidden='true'></i>Edit</button>
                                    </form>
                                </div>";
            $this->member_text= "";
            $this->profile_text= "<button id='org_edit_profile_btn' onclick='document.getElementById(\'upload_org_profile_btn\').click()'>
                                        <i class='fa fa-camera' aria-hidden='true'></i>CHANGE
                                    </button>";
            $this->cover_photo_text= "<button id='org_edit_cover_but' onclick='document.getElementById(\'org_upload_cover_btn\').click()'>
                                        <i class='fa fa-camera' aria-hidden='true'></i>CHANGE
                                    </button>";                    
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
        public function show_coleader_option($nic){
            echo '';
        }
        public function show_member_option($nic){
            echo '';
        }
        public function change_profile_option(){
            echo '';
        }
        public function change_coverphoto_option(){
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
        public function show_coleader_option($nic){
            echo '';
        }
        public function show_member_option($nic){
            echo '';
        }
        public function change_profile_option(){
            echo '';
        }
        public function change_coverphoto_option(){
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
        public function show_coleader_option($nic){
            echo '';
        }
        public function show_member_option($nic){
            echo "<div class='add_remove rem'><a href='/organization/member_operation.php?type=member_remove&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_but'>Remove</button></a></div>
                <div class='add_remove pro'><a href='/organization/member_operation.php?type=member_promote_to_coleader&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_but'>Promote to co_leader</button></a></div>";
        }
        public function change_profile_option(){
            echo $this->profile_text;
        }
        public function change_coverphoto_option(){
            echo $this->cover_photo_text;
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
        public function show_coleader_option($nic){
            echo "<div class='add_remove_div none'>
            <div class='add_remove rem'><a href='/organization/member_operation.php?type=coleader_remove&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_but'>Remove</button></a></div>
            <div class='add_remove pro'><a href='/organization/member_operation.php?type=coleader_promote_to_leader&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_but'>Promote to leader</button></a></div>
            <div class='add_remove pro'><a href='/organization/member_operation.php?type=coleader_depromote_to_member&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_but'>De-promote to member</button></a></div>
            </div>";
        }
        public function show_member_option($nic){
            echo  "<div class='add_remove rem'><a href='/organization/member_operation.php?type=member_remove&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_but'>Remove</button></a></div>
                <div class='add_remove pro'><a href='/organization/member_operation.php?type=member_promote_to_coleader&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_but'>Promote to co_leader</button></a></div>
                <div class='add_remove pro'><a href='/organization/member_operation.php?type=member_promote_to_leader&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_but'>Promote to leader</button></a></div>";
        }
        public function change_profile_option(){
            echo $this->profile_text;
        }
        public function change_coverphoto_option(){
            echo $this->cover_photo_text;
        }
    }

    
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
?>