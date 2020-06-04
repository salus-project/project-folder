<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    $query="select * from organizations where org_id=".$_GET['selected_org'];
    $result=($con->query($query))->fetch_assoc();
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href='/organization/view_org_header.css'>
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
                    <img id='logo' src ="org_logos/<?php echo $result['org_id'] ?>.jpg" alt="<?php echo $result['org_id'] . '.jpg'?>" style="z-index:3;">
                    </div>
                </div>
            </div>
            <div id=title_sub>
                <div id=org_name>
                    <h2 id=org_name_h2><?php echo $result['org_name'] ?></h2>
                    <?php
                        if($result['leader']==$_SESSION['user_nic']){
                            echo "<div id=edit_btn_container >";
                                echo "<form action=edit_org.php method=get>";
                                    echo "<button id=edit_btn type='submit' name=edit_detail value=".$_GET['selected_org'].">Edit</button>";
                                echo "</form>";
                            echo"</div>";
                        }
                    
                        $sql1="SELECT `members` from `organizations` where org_id=".$_GET['selected_org'];
                        $result1=($con->query($sql1))->fetch_assoc();
                        $status=explode(" ",$result1['members']);
                        $nic=$_SESSION['user_nic'];
                        $leader=$result['leader'];
                        $co_leader=$result['co_leader'];


                        if(in_array($nic, $status) or $leader===$nic or $co_leader===$nic){
                            echo "<div id=edit_btn_container >";
                                echo "<form action=org_join_leave.php method=get>";
                                    echo "<button id=leave_btn type='submit' name=edit_detail value=".$_GET['selected_org'].">Leave</button>";
                                echo "</form>";
                            echo"</div>";
                        }else{
                            echo "<div id=edit_btn_container >";
                                echo "<form action=org_join_leave.php method=get>";
                                    echo "<button id=edit_btn type='submit' name=edit_detail value=".$_GET['selected_org'].">JoinAsMember</button>";
                                echo "</form>";
                            echo"</div>";

                        }
                    ?>
                    
                </div>
                <div id=discription>
                    <h4 id=org_detail><?php echo $result['discription'] ?></h4>
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
        <script src='/organization/view_org.js'></script>
        
    </body>

</html>