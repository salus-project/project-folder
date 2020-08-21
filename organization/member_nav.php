<?php
    $query="SELECT * FROM org_members INNER JOIN civilian_detail ON org_members.NIC_num = civilian_detail.NIC_num where org_members.org_id='".$_GET['selected_org']."' and org_members.role='leader';
            SELECT * FROM org_members INNER JOIN civilian_detail ON org_members.NIC_num = civilian_detail.NIC_num where org_members.org_id='".$_GET['selected_org']."' and org_members.role='coleader' ;
            SELECT * FROM org_members INNER JOIN civilian_detail ON org_members.NIC_num = civilian_detail.NIC_num where org_members.org_id='".$_GET['selected_org']."' and org_members.role='member';";
    $leader_nic='';

    $leader_detail=array();
    if(mysqli_multi_query($con,$query)){
        $result = mysqli_store_result($con);
        if(mysqli_num_rows($result)>0){     
            $leader_detail= mysqli_fetch_assoc($result);
            $leader_nic=$leader_detail['NIC_num'];
        }else{
            $leader_nic='';
        }
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result1 = mysqli_store_result($con);
        $coleader_detail = mysqli_fetch_all($result1,MYSQLI_ASSOC);
        mysqli_free_result($result1);

        mysqli_next_result($con);
        $result1 = mysqli_store_result($con);
        $member_detail = mysqli_fetch_all($result1,MYSQLI_ASSOC);
        mysqli_free_result($result1);
    }
?>

        <title>view organization</title>
        <link rel="stylesheet" href='/css_codes/view_org.css'>
        <link rel="stylesheet" href='/css_codes/publ.css'>

        <div id='org_body'>           
            <table class='view_org_table'>
                <tr><td colspan='2' id='detail'>DETAILS</td></tr>
                <tr>
                    <td>District</td>
                    <td><?php echo $org_detail['district'] ?></td>
                </tr>
                <tr>
                    <td>Contact email</td>
                    <td><?php echo $org_detail['email'] ?></td>
                </tr>
                <tr>
                    <td>Contact number</td>
                    <td><?php echo $org_detail['phone_num'] ?></td>
                </tr>
            </table>
        </div>    
    
        <table class='member_table'>       
            <tr>              
                <td class='member'><b>LEADER</b></td></tr>
            <?php
                if(isset($leader_detail['NIC_num'])){
                    $leader_name=$leader_detail['first_name']." ".$leader_detail['last_name'];
                }else{
                    $leader_name='No leader';
                }
                if($leader_nic==$_SESSION['user_nic']){
                    $leader_name='You';
                }
                $profile_path = "http://d-c-a.000webhostapp.com/Profiles/resized/" . $leader_nic . ".jpg";
                
                echo    "<tr class='role_div'>
                            <td class='role_name'>
                                <a class='mem_nav_a' href='/view_profile.php?id=".$leader_nic."'>".
                                    "<img src='".$profile_path."' alt='oops' class='side_nav_profile role_pic'>".
                                    $leader_name."
                                </a>
                            </td>
                        </tr>";
        echo '</table>';
        echo '<table class="member_table">';
            echo "<tr><td class='member'><b>CO LEADERS</b></td></tr>";
                foreach($coleader_detail as $row){
                    if($row['NIC_num']==$_SESSION['user_nic']){
                        $coleader_name='You';
                    }else{
                        $coleader_name=$row['first_name']." ".$row['last_name'];
                    }

                    $profile_path = "http://d-c-a.000webhostapp.com/Profiles/resized/" . $row['NIC_num'] . ".jpg";

                    echo    "<tr>
                                <td>
                                    <div class='role'>
                                        <div class='role_div'>
                                            <div class='role_pic'>
                                                <img src='".$profile_path."' alt='oops' class='side_nav_profile'>
                                            </div>
                                            <div class='role_name'>
                                                <a class='mem_nav_a' href='/view_profile.php?id=".$row['NIC_num']."'>".$coleader_name."</a>
                                            </div>                                           
                                        </div>";
                                    echo "<div class='add_remove_div none'>";
                                            $viewer->show_coleader_option($row['NIC_num']);
                                    echo "</div>";
                                    
                                    echo "</div>";
                                    
                           echo    "</td>";
                        echo   "</tr>"; 
                                                
                }
                echo "<tr >
                        <td>
                            <div class='add_div none'>";
                                $viewer->show_coleader_input();
                echo        "</div>
                        </td>
                    </tr>"; 
            
        echo '</table>';
        echo '<table class="member_table">';
                echo "<tr><td class='member'><b>MEMBERS</b></td></tr>";
                foreach($member_detail as $row){
                    if($row['NIC_num']==$_SESSION['user_nic']){
                        $member_name='You';
                    }else{
                        $member_name=$row['first_name']." ".$row['last_name'];
                    }
                    $profile_path = "http://d-c-a.000webhostapp.com/Profiles/resized/" . $row['NIC_num'] . ".jpg";
                    
                    echo    "<tr>
                                <td>";
                                
                                   
                               echo " <div class='role'>
                                        <div class='add_remove_div'>";
                                            $viewer->show_member_option($row['NIC_num']);
                                echo "  </div>";
                                     echo   "<div class='role_div'>
                                            <div class='role_pic'>
                                                <img src='".$profile_path."' alt='oops' class='side_nav_profile'>
                                            </div>
                                            <div class='role_name'>
                                                <a class='mem_nav_a' href='/view_profile.php?id=".$row['NIC_num']."'>".$member_name."</a>
                                            </div>                                           
                                        </div>";                                       
                              echo "</div>";                                    
                            echo "</td>";
                        echo "</tr>";
                          
                }  
                echo "<tr>
                        <td>
                            <div class='add_div none'>";
                                $viewer->show_member_input();
                echo        "</div>
                        </td>
                    </tr>";       
        echo '</table>';
    ?>       
    <script>
        $(".role").click(function(){
            $(".add_remove_div",this).toggle();
        });

        $(".role").click(function(){
            $(".add_div",this).toggle();
        });
    </script>

