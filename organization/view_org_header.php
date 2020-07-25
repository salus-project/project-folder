<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    
    if(!isset($_GET['selected_org'])){
        $_GET['selected_org']=$_GET['org_id'];
    }
    $org_id=$_GET['selected_org'];
    $query="select * from organizations where org_id=".$_GET['selected_org'].";
    select * from org_members where org_id=".$_GET['selected_org']." and NIC_num='".$_SESSION['user_nic']."';";

    $text_role='';
    $member_arr=$co_leader_arr=array();
    if(mysqli_multi_query($con,$query)){
        $result = mysqli_store_result($con);
        $org_detail= mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result1 = mysqli_store_result($con);
        if(mysqli_num_rows($result1)>0){
            $member_detail = mysqli_fetch_assoc($result1);
            if($member_detail['role']=='leader'){
                $text_role='leader';
            }elseif($member_detail['role']=='coleader'){
                $text_role='co-leader';
            }elseif($member_detail['role']=='member'){
                $text_role='member';
            }
        }else{
            $text_role='visitor';
        }
        mysqli_free_result($result1);
    }
    require 'view_org-strategy.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href='/css_codes/view_org_header.css'>
        <link rel="stylesheet" href='/css_codes/member_nav.css.css'>
    </head>
    <body>
        
        <script>
            btnPress(6);
        </script>
        <div class=org_title>
            <div id='org_cover'>
                <?php
                    $org_cover_path = "http://d-c-a.000webhostapp.com/Covers/" . $org_detail['org_id'] . ".jpg";
                    $org_cover_path_header = get_headers($org_cover_path);
                    if($org_cover_path_header[0] != 'HTTP/1.1 200 OK'){
                        $org_cover_path = "http://d-c-a.000webhostapp.com/Covers/default.jpg";
                    }
                ?>
                <img id="org_cover_photo" src="<?php echo $org_cover_path;?>" alt="Opps..." class="org_cover_pic">
                <div id='org_profile_edit'>
                    <div class="org_profile_container">
                        <?php
                            $org_profile_path = "http://d-c-a.000webhostapp.com/Profiles/" . $org_detail['org_id'] . ".jpg";
                            $org_profile_path_header = get_headers($org_profile_path);
                            if($org_profile_path_header[0] != 'HTTP/1.1 200 OK'){
                                $org_profile_path = "http://d-c-a.000webhostapp.com/Profiles/default.jpg";
                            }
                        ?>
                        <img src="<?php echo $org_profile_path;?>" alt="Opps..." class="org_profile_pic">
                    </div>
                    <form method='post' action="http://d-c-a.000webhostapp.com/upload.php" enctype="multipart/form-data" id=upload_profile_form>
                        <input type=file name=upload_file accept="image/jpeg" id=upload_org_profile_btn style="display:none" onchange="this.parentElement.submit()">
                        <input type=hidden name="directory" value="Profiles/">
                        <input type=hidden name="filename" value="<?php echo $org_detail['org_id']?>">
                        <input type=hidden name="header" value="true">
                        <input type=hidden name="resize" value="true">
                    </form>
                    <?php
                        $viewer->change_profile_option();
                    ?>
                </div>
            </div>
            <div id='org_gradient_div'>
                <div id='org_name_container'>
                    <span id='org_name'><?php echo $org_detail['org_name']; ?></span><br>
                    <span id=org_detail><?php echo $org_detail['discription'] ?></span>
                </div>
                <form method='post' action="http://d-c-a.000webhostapp.com/upload.php" enctype="multipart/form-data" id=upload_cover_form>
                    <input type=file name=upload_file accept="image/jpeg" id=org_upload_cover_btn style="display:none" onchange="this.parentElement.submit()">
                    <input type=hidden name="directory" value="Covers/">
                    <input type=hidden name="filename" value="<?php echo $_SESSION['user_nic']?>">
                    <input type=hidden name="header" value="true">
                </form>
                <?php
                    $viewer->change_coverphoto_option();
                ?>
            </div>           
            <div id=title_sub>
                <?php
                    $viewer->show_membership_button();
                    $viewer->show_edit_button();
                ?>
            </div>
        </div>
        <div id=org_button_container>
            <div id=home_button_container>
                <form action=/organization method=get>
                    <button id=home_btn type='submit' name=chat value=<?php echo $_GET['selected_org'] ?>>Home</button>
                </form>
            </div>
            <div id=chat_button_container>
                <form action=/organization/chat method=get>
                    <button id=chat_btn type='submit' name=chat value=<?php echo $_GET['selected_org'] ?>>Group chat</button>
                </form>
            </div>
            <div id=event_button_container>
                <button id='event_button'>Events</button>
                <div id=event_list_container>
                </div>
            </div>
        </div>
        <script>
            const selected_org = "<?php echo $_GET['selected_org'] ?>";
        </script>
        <script src='/js/view_org.js'></script>
        <div id='org_main_body'>
            <div id='org_side_nav'>
                <?php include($_SERVER['DOCUMENT_ROOT']."/organization/member_nav.php");?>
            </div>
            <div id='org_sub_body'>