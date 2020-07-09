<?php
require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
$viewer_nic = $_GET['id'];
$sql="SELECT * FROM civilian_detail where NIC_num='".$viewer_nic."'";
$viewer = $con->query($sql);
while($row=$viewer->fetch_assoc()){
    $first_name=$row['first_name'];
    $last_name=$row['last_name'];
    $gender=$row['gender'];
    $district=$row['district'];
    $Occupation=$row['Occupation'];
    $address=$row['address'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Profile</title>
    <link rel="stylesheet" href="css_codes/homePage.css">

</head>

<body>
<div class="title">
    <div id='cover'>
        <?php
        $cover_path = "http://eme-service.000webhostapp.com/Covers/" . $viewer_nic . ".jpg";
        $cover_path_header = get_headers($cover_path);
        if($cover_path_header[0] != 'HTTP/1.1 200 OK'){
            $cover_path = "http://eme-service.000webhostapp.com/Covers/default.jpg";
        }
        ?>
        <img id="cover_photo" src="<?php echo $cover_path;?>" alt="Opps..." class="cover_pic">
        <form method='post' action="http://eme-service.000webhostapp.com/upload.php" enctype="multipart/form-data" id=upload_cover_form>

            <input type=file name=upload_file accept="image/jpeg" id=upload_cover_btn style="display:none" onchange="this.parentElement.submit()">
            <input type=hidden name="directory" value="Covers/">
            <input type=hidden name="filename" value="<?php echo $viewer_nic?>">
            <input type=hidden name="header" value="true">
        </form>
    </div>
    <div class="profile_container">
        <?php
        $profile_path = "http://eme-service.000webhostapp.com/Profiles/" . $viewer_nic . ".jpg";
        $profile_path_header = get_headers($profile_path);
        if($profile_path_header[0] != 'HTTP/1.1 200 OK'){
            $profile_path = "http://eme-service.000webhostapp.com/Profiles/default.jpg";
        }
        ?>
        <img src="<?php echo $profile_path;?>" alt="Opps..." class="profile_pic">
        <form method='post' action="http://eme-service.000webhostapp.com/upload.php" enctype="multipart/form-data" id=upload_profile_form>

            <input type=file name=upload_file accept="image/jpeg" id=upload_profile_btn style="display:none" onchange="this.parentElement.submit()">
            <input type=hidden name="directory" value="Profiles/">
            <input type=hidden name="filename" value="<?php echo $viewer_nic?>">
            <input type=hidden name="header" value="true">
        </form>
    </div>
    <div id='name_container'>
        <span id='name'><?php echo $first_name . " " . $last_name; ?></span>
    </div>
</div>

<div id='home_sub_body'>
    <div class="detail">
        <div id='intro_heading'><b>Intro</b></div>
        <table style="width:100%">
            <tr>
                <td><?php echo "Name" ?></td>
                <td><?php echo $first_name . " " . $last_name; ?></td>
            </tr>
            <tr>
                <td><?php echo "Gender" ?></td>
                <td><?php echo $gender; ?></td>
            </tr>
            <tr>
                <td><?php echo "District" ?></td>
                <td><?php echo $district; ?></td>
            </tr>
            <tr>
                <td><?php echo "Occupation" ?></td>
                <td><?php echo $Occupation; ?></td>
            </tr>
            <tr>
                <td><?php echo "Address" ?></td>
                <td><?php echo $address; ?></td>
            </tr>
        </table>
    </div>
    <div id="content">
        <?php
        $author=$viewer_nic;
        $query="select * from public_posts  WHERE author='$author' ORDER BY post_index DESC";
        $result=$con->query($query);
        while($row=$result->fetch_assoc()){
            echo "<div id='posts'>";
            echo "<div id='post_title'>";

            echo  "<div id='post_date'> Date: " . $row['date'] . "</div>";
            echo "</div>";
            echo "<div id='post_content'>" . $row['content'] . "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>

</body>

</html>