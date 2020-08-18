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
        public function show_coleader_input(){
            $this->role->show_coleader_input();
        }
        public function show_member_input(){
            $this->role->show_member_input();
        }
        public function show_title_buttons(){
            $this->role->show_title_button();
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
            $this->profile_text= "<button id='org_edit_profile_btn' onclick='document.getElementById(\"upload_org_profile_btn\").click()'>
                                        <i class='fa fa-camera' aria-hidden='true'></i>CHANGE
                                    </button>
                                    <form method='post' action='http://d-c-a.000webhostapp.com/upload.php' enctype='multipart/form-data' id=upload_profile_form>
                                        <input type=file name=upload_file accept='image/jpeg' id='upload_org_profile_btn' style='display:none' onchange='this.parentElement.submit()'>
                                        <input type=hidden name='directory' value='Organization/Profiles/'>
                                        <input type=hidden name='filename' value='".$_GET['selected_org']."'>
                                        <input type=hidden name='header' value='true'>
                                        <input type=hidden name='resize' value='true'>
                                    </form>";
            $this->cover_photo_text= "<button id='org_edit_cover_but' onclick='document.getElementById(\"org_upload_cover_btn\").click()'>
                                        <i class='fa fa-camera' aria-hidden='true'></i>CHANGE
                                    </button>
                                    <form method='post' action='http://d-c-a.000webhostapp.com/upload.php' enctype='multipart/form-data' id=upload_profile_form>
                                        <input type=file name=upload_file accept='image/jpeg' id='org_upload_cover_btn' style='display:none' onchange='this.parentElement.submit()'>
                                        <input type=hidden name='directory' value='Organization/Covers/'>
                                        <input type=hidden name='filename' value='".$_GET['selected_org']."'>
                                        <input type=hidden name='header' value='true'>
                                        <input type=hidden name='resize' value='false'>
                                    </form>";
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
        public function show_coleader_input(){
            echo '';
        }
        public function show_member_input(){
            echo '';
        }
        public function show_title_buttons(){
            echo    "<div id=chat_button_container>
                        <a action='/organization/suggestions'>
                            <button id=chat_btn name=chat value=".$_GET['selected_org'].">Suggestion</button>
                        </a>
                    </div>
                    <div id=event_button_container>
                        <button id='event_button'>Events</button>
                        <div id=event_list_container>
                        </div>
                    </div>";
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
        public function show_coleader_input(){
            echo '';
        }
        public function show_member_input(){
            echo '';
        }
        public function show_title_buttons(){
            echo    "<div id=chat_button_container>
                        <form action=/organization/chat method=get>
                            <button id=chat_btn type='submit' name=chat value=".$_GET['selected_org'].">Group chat</button>
                        </form>
                    </div>
                    <div id=event_button_container>
                        <button id='event_button'>Events</button>
                            <div id=event_list_container>
                        </div>
                    </div>";
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
        public function show_coleader_input(){
            echo '';
        }
        public function show_member_input(){
            echo "<div class='add_role'><form method='get' action='/organization/member_operation.php'><input class='add_mem_input' name='nic_num' placeholder='Enter member NIC'/><button class='add_role_btn' type='submit'>Add</button><input type='hidden' name='type' value='add_member'><input type='hidden' name='org_id' value='".$_GET['selected_org']."'></form></div>";        
        }
        public function show_title_buttons(){
            echo    "<div id=chat_button_container>
                        <form action=/organization/chat method=get>
                            <button id=chat_btn type='submit' name=chat value=".$_GET['selected_org'].">Group chat</button>
                        </form>
                    </div>
                    <div id=event_button_container>
                        <button id='event_button'>Events</button>
                        <div id=event_list_container>
                        </div>
                    </div>";
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
        public function show_coleader_input(){
            echo "<div class='add_role'><form method='get' action='/organization/member_operation.php'><input class='add_mem_input' name='nic_num' placeholder='Enter coleader NIC'/><button class='add_role_btn' type='submit'>Add</button><input type='hidden' name='type' value='add_coleader'><input type='hidden' name='org_id' value='".$_GET['selected_org']."'></form></div>";        
        }
        public function show_member_input(){
            echo "<div class='add_role'><form method='get' action='/organization/member_operation.php'><input class='add_mem_input' name='nic_num' placeholder='Enter member NIC'/><button class='add_role_btn' type='submit'>Add</button><input type='hidden' name='type' value='add_member'><input type='hidden' name='org_id' value='".$_GET['selected_org']."'></form></div>";        
        }
        public function show_title_buttons(){
            echo    "<div id=chat_button_container>
                        <form action=/organization/chat method=get>
                            <button id=chat_btn type='submit' name=chat value=".$_GET['selected_org'].">Group chat</button>
                        </form>
                    </div>
                    <div id=event_button_container>
                        <button id='event_button'>Events</button>
                        <div id=event_list_container>
                        </div>
                    </div>";
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