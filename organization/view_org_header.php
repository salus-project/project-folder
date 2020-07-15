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
        <div id=org_title>
            <div id=title_margin>
                <div id=org_logo>
                    <div style="height:1px;width:1px">
                    <img id=logo src=/organization/org_logos/default.png style="z-index:2;">
                    <img id='logo' src ="/organization/org_logos/<?php echo $org_detail['org_id'] ?>.jpg" alt="<?php echo $org_detail['org_id'] . '.jpg'?>" style="z-index:3;">
                    </div>
                </div>
            </div>
            <div id=title_sub>
                <div id=org_name>
                    <h2 id=org_name_h2><?php echo $org_detail['org_name'] ?></h2>
                    <?php
                        $viewer->show_membership_button();
                        $viewer->show_edit_button();
                    ?>
                </div>
                <div id=discription>
                    <h4 id=org_detail><?php echo $org_detail['discription'] ?></h4>
                </div>
            </div>
        </div>
        <div id=org_button_container>
            <form action=/organization/chat method=get>
                <button id=chat_btn type='submit' name=chat value=<?php echo $_GET['selected_org'] ?>>Group chat</button>
            </form>
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