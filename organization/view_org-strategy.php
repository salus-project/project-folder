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
        public function show_title_button(){
            $this->role->show_title_button();
        }
        public function show_event_link(){
            $this->role->show_event_link();
        }
        public function show_post_button(){
            $this->role->show_post_button();
        }
    }


    abstract class Role{
        protected $join_text;
        protected $leave_text;
        protected $edit_text;
        protected $coleader_text;
        protected $profile_text;
        protected $cover_photo_text;
        protected $create_post_text;

        public function __construct(){
            $this->join_text =  "<div id='membership_btn_container' class='header_btn_container'>
                                    <form action=org_join_leave.php method=get>
                                        <button id=membership_btn class='header_btn' type='submit' name=org_id value=".$_GET['selected_org']."><i class='fa fa-handshake-o' aria-hidden='true'></i>Join</button>
                                    </form>
                                </div>";
            $this->leave_text = "<div id='membership_btn_container' class='header_btn_container'>
                                    <form id='org_leave_form' action=org_join_leave.php method=get>
                                        <button id=membership_btn onclick='confirmFn()' class='header_btn' type='button' ><input type=hidden name=org_id value=".$_GET['selected_org']."><i class='fa fa-share-square-o' aria-hidden='true'></i></i>Leave</button>
                                    </form>
                                </div>";
            $this->edit_text= "<div id='edit_btn_container' class='header_btn_container'>
                                    <form action=edit_org.php method=get>
                                        <button id='edit_btn' class='header_btn' type='submit' name=org_id value=".$_GET['selected_org']."><i class='fa fa-pencil-square-o' aria-hidden='true'></i>Edit</button>
                                    </form>
                                </div>
                                <div id=del_btn_container class='header_btn_container'>
                                        <button onclick='delOrgFn(\"".$_GET['selected_org']."\")' id='delete_btn' class='header_btn'><i class='fa fa-pencil-square-o' aria-hidden='true'></i>Dismiss</button>
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
            $this->create_post_text="<div id='new_post'>
                                    </div>
                                    <script>
            var newPost = new NewPost('organization', '".$_GET['selected_org'] ."');
            </script>";
        }
        abstract function show_membership_button();
        abstract function show_edit_button();
        abstract function show_post_button();
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
        public function show_title_button(){
            echo    "<div id=chat_button_container>
                        <a href='/organization/suggestions/?org_id=".$_GET['selected_org']."'>
                            <button id=chat_btn name=org_id value=".$_GET['selected_org'].">Suggestion</button>
                        </a>
                    </div>
                    <div id=event_button_container>
                        <button id='event_button'>Events</button>
                        <div id=event_list_container>
                        </div>
                    </div>";
        }
        public function show_event_link(){
            echo '/organization/visitor_event';
        }
        public function show_post_button(){
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
        public function show_coleader_input(){
            echo '';
        }
        public function show_member_input(){
            echo '';
        }
        public function show_title_button(){
            echo    "<div id=chat_button_container>
                        <form action=/organization/chat method=get>
                            <button id=chat_btn type='submit' name=org_id value=".$_GET['selected_org'].">Group chat</button>
                        </form>
                    </div>
                    <div id=event_button_container>
                        <button id='event_button'>Events</button>
                            <div id=event_list_container>
                        </div>
                    </div>";
        }
        public function show_event_link(){
            echo '/organization/visitor_event';
        }
        public function show_post_button(){
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
            echo "<div class='add_remove rem'><a class='add_remove_a' href='/organization/member_operation.php?type=member_remove&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_button'>Remove</button></a></div>
                <div class='add_remove pro'><a class='add_remove_a' href='/organization/member_operation.php?type=member_promote_to_coleader&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_button'>Promote to co_leader</button></a></div>";
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
            echo "<form method='get' action='/organization/member_operation.php'><div class='add_role'><div class='addd_remove_main'><input type='hidden' name='nic_num'/><input class='add_mem_input' placeholder='Enter member name'/></div><div class='add_remove_but'><button class='add_role_btn' type='submit'>Add</button></div><input type='hidden' name='type' value='add_member'><input type='hidden' name='org_id' value='".$_GET['selected_org']."'></div></form>";        
        }
        public function show_title_button(){
            echo    "<div id=chat_button_container>
                        <form action=/organization/chat method=get>
                            <button id=chat_btn type='submit' name=org_id value=".$_GET['selected_org'].">Group chat</button>
                        </form>
                    </div>
                    <div id=event_button_container>
                        <button id='event_button'>Events</button>
                        <div id=event_list_container>
                        </div>
                    </div>";
        }
        public function show_event_link(){
            echo '/organization/event';
        }
        public function show_post_button(){
            echo $this->create_post_text;
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
            echo "<div class='add_remove rem'><a class='add_remove_a' href='/organization/member_operation.php?type=coleader_remove&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_button'>Remove</button></a></div>
            <div class='add_remove pro'><a class='add_remove_a' href='/organization/member_operation.php?type=coleader_promote_to_leader&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_button'>Promote to leader</button></a></div>
            <div class='add_remove pro'><a class='add_remove_a' href='/organization/member_operation.php?type=coleader_depromote_to_member&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_button'>De-promote to member</button></a></div>";
        }
        public function show_member_option($nic){
            echo  "<div class='add_remove rem'><a class='add_remove_a' href='/organization/member_operation.php?type=member_remove&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_button'>Remove</button></a></div>
                <div class='add_remove pro'><a class='add_remove_a' href='/organization/member_operation.php?type=member_promote_to_coleader&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_button'>Promote to co_leader</button></a></div>
                <div class='add_remove pro'><a class='add_remove_a' href='/organization/member_operation.php?type=member_promote_to_leader&org_id=".$_GET['selected_org']."&nic=".$nic."'><button class='add_remove_button'>Promote to leader</button></a></div>";
        }
        public function change_profile_option(){
            echo $this->profile_text;
        }
        public function change_coverphoto_option(){
            echo $this->cover_photo_text;
        }
        public function show_coleader_input(){
            echo "<form method='get' action='/organization/member_operation.php'><div class='add_role'><div class='addd_remove_main'><input type='hidden' name='nic_num'/><input class='add_mem_input' placeholder='Enter coleader name'/></div><div class='add_remove_but'><button class='add_role_btn' type='submit'>Add</button></div><input type='hidden' name='type' value='add_coleader'><input type='hidden' name='org_id' value='".$_GET['selected_org']."'></div></form>";        
        }
        public function show_member_input(){
            echo "<form method='get' action='/organization/member_operation.php'><div class='add_role'><div class='addd_remove_main'><input type='hidden' name='nic_num'/><input class='add_mem_input' placeholder='Enter member name'/></div><div class='add_remove_but'><button class='add_role_btn' type='submit'>Add</button></div><input type='hidden' name='type' value='add_member'><input type='hidden' name='org_id' value='".$_GET['selected_org']."'></div></form>";        
        }
        public function show_title_button(){
            echo    "<div id=chat_button_container>
                        <form action=/organization/chat method=get>
                            <button id=chat_btn type='submit' name=org_id value=".$_GET['selected_org'].">Group chat</button>
                        </form>
                    </div>
                    <div id=event_button_container>
                        <button id='event_button'>Events</button>
                        <div id=event_list_container>
                        </div>
                    </div>";
        }
        public function show_event_link(){
            echo '/organization/event';
        }
        public function show_post_button(){
            echo $this->create_post_text;
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