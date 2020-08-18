<?php
    require $_SERVER['DOCUMENT_ROOT']."/anonymous/ano_header.php";
    
    $org_id=$_GET['org_id'];
    $query="select * from organizations where org_id=".$_GET['org_id'].";";

    if(mysqli_query($con,$query)){
        $result = mysqli_query($con,$query);
        $org_detail= mysqli_fetch_assoc($result);
    } 
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href='/css_codes/view_org_header.css'>
        <link rel="stylesheet" href='/css_codes/ano_view_org.css'>

    </head>
    <body>
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
                   
                </div>
            </div>
            <div id='org_gradient_div'>
                <div id='org_name_container'>
                    <span id='org_name'><?php echo $org_detail['org_name']; ?></span><br>
                    <span id=org_detail><?php echo $org_detail['discription'] ?></span>
                </div>
            </div>

                
        </div>
        
        <div id="table_caontainer">
            <div class="head" colspan="2">
                Organization Detail
            </div>
            <div class="event_con">
                <table id="view_event_table">           
                    <tbody>
                        <tr>
                            <td class="view_event_td">District</td>
                            <td id="column2"><?php echo $org_detail['district'] ?></td>
                        </tr>
                        <tr>
                            <td class="view_event_td">Contact email</td>
                            <td id="column2"><?php echo $org_detail['email'] ?></td>
                        </tr>
                        <tr>
                            <td class="view_event_td">Contact number</td>
                            <td id="column2"><?php echo $org_detail['phone_num']!=0?$org_detail['phone_num']:"Not given"; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>