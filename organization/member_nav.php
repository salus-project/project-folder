<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
    $org_id='15';
    $query="SELECT * FROM org_members INNER JOIN civilian_detail ON org_members.NIC_num = civilian_detail.NIC_num where org_members.org_id='$org_id' and org_members.role='leader';
            SELECT * FROM org_members INNER JOIN civilian_detail ON org_members.NIC_num = civilian_detail.NIC_num where org_members.org_id='$org_id' and org_members.role='coleader' ;
            SELECT * FROM org_members INNER JOIN civilian_detail ON org_members.NIC_num = civilian_detail.NIC_num where org_members.org_id='$org_id' and org_members.role='member';";

    if(mysqli_multi_query($con,$query)){
        $result = mysqli_store_result($con);
        $leader_detail= mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result1 = mysqli_store_result($con);
        $coleader_detail = mysqli_fetch_all($result1,MYSQLI_ASSOC);
        mysqli_free_result($result1);

        mysqli_next_result($con);
        $result1 = mysqli_store_result($con);
        $member_detail = mysqli_fetch_all($result1,MYSQLI_ASSOC);
        mysqli_free_result($result1);

        echo '<table>';
        echo "<tr><td><b>LEADER</b></td></tr>";
        if($leader_detail['NIC_num']==$_SESSION['user_nic']){
            $leader_name='You';
        }else{
            $leader_name=$leader_detail['first_name']." ".$leader_detail['last_name'];
        }
        $profile_path = "http://eme-service.000webhostapp.com/Profiles/resized/" . $leader_detail['NIC_num'] . ".jpg";
        $profile_path_header = get_headers($profile_path);
        if($profile_path_header[0] != 'HTTP/1.1 200 OK'){
            $profile_path = "http://eme-service.000webhostapp.com/Profiles/resized/default.jpg";
        }
        
        echo    "<tr>
                    <td>
                        <a class='side_nav_a' href='/view_profile.php?id=".$leader_detail['NIC_num']."'>".
                            "<img src='".$profile_path."' alt='oops' class='side_nav_profile'>".
                            $leader_name."
                        </a>
                    </td>
                </tr>";
            
        echo "<tr><td><b>CO LEADERS</b></td></tr>";
        foreach($coleader_detail as $row){
            if($row['NIC_num']==$_SESSION['user_nic']){
                $coleader_name='You';
            }else{
                $coleader_name=$row['first_name']." ".$row['last_name'];
            }
            $profile_path = "http://eme-service.000webhostapp.com/Profiles/resized/" . $row['NIC_num'] . ".jpg";
            $profile_path_header = get_headers($profile_path);
            if($profile_path_header[0] != 'HTTP/1.1 200 OK'){
                $profile_path = "http://eme-service.000webhostapp.com/Profiles/resized/default.jpg";
            }
            
            echo    "<tr>
                        <td>
                            <a class='side_nav_a' href='/view_profile.php?id=".$row['NIC_num']."'>".
                                "<img src='".$profile_path."' alt='oops' class='side_nav_profile'>".
                                $coleader_name."
                            </a>
                        </td>
                    </tr>";
            
        }

        echo "<tr><td><b>MEMBERS</b></td></tr>";
        foreach($member_detail as $row){
            if($row['NIC_num']==$_SESSION['user_nic']){
                $member_name='You';
            }else{
                $member_name=$row['first_name']." ".$row['last_name'];
            }
            $profile_path = "http://eme-service.000webhostapp.com/Profiles/resized/" . $row['NIC_num'] . ".jpg";
            $profile_path_header = get_headers($profile_path);
            if($profile_path_header[0] != 'HTTP/1.1 200 OK'){
                $profile_path = "http://eme-service.000webhostapp.com/Profiles/resized/default.jpg";
            }
            
            echo    "<tr>
                        <td>
                            <a class='side_nav_a' href='/view_profile.php?id=".$row['NIC_num']."'>".
                                "<img src='".$profile_path."' alt='oops' class='side_nav_profile'>".
                                $member_name."
                            </a>
                        </td>
                    </tr>";
            
        }
        echo '</table>';
    }
?>