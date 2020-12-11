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
    <script src="https://kit.fontawesome.com/b17fa3a18c.js" crossorigin="anonymous"></script>
    <script src="/common/post/post.js"></script>
    <link rel="stylesheet" href='/css_codes/publ.css'>
</head>

<body>
<div class="title">
    <div id='cover'>
        <?php
        $cover_path = "/common/documents/Covers/" . $viewer_nic . ".jpg";
        ?>
        <img id="cover_photo" src="<?php echo $cover_path;?>" alt="Opps..." class="cover_pic">
    
        <div id='profile_edit'>
            <div class="profile_container">
                <?php
                    $profile_path = "/common/documents/Profiles/" . $viewer_nic . ".jpg";
                ?>
                <img src="<?php echo $profile_path;?>" alt="Opps..." class="my_profile_pic">
            </div>
        </div>
        <div id='gradient_div'>
            <div id='name_container'>
                <span id='name'><?php echo $first_name . " " . $last_name; ?></span>
            </div>
        </div>
        <?php if($viewer_nic!=$_SESSION['user_nic']){
            ?>
        <a id="send_message" href="/message/?to_person=<?php echo $viewer_nic; ?>">
            <i class="fas fa-comments"></i> message
        </a>
        <?php } ?>
    </div>    
</div>

<div id='home_sub_body'>
    <div class="person_detail">
        <div id='intro_heading'><b>Intro</b></div>
        <table class='home_table'>
            <tr>
                <td class='home_view_td'><?php echo "Name" ?></td>
                <td class='home_view_td'><?php echo $first_name . " " . $last_name; ?></td>
            </tr>
            <tr>
                <td class='home_view_td'><?php echo "Gender" ?></td>
                <td class='home_view_td'><?php echo $gender; ?></td>
            </tr>
            <tr>
                <td class='home_view_td'><?php echo "District" ?></td>
                <td class='home_view_td'><?php echo $district; ?></td>
            </tr>
            <tr>
                <td class='home_view_td'><?php echo "Occupation" ?></td>
                <td class='home_view_td'><?php echo $Occupation; ?></td>
            </tr>
            <tr>
                <td class='home_view_td'><?php echo "Address" ?></td>
                <td class='home_view_td'><?php echo $address; ?></td>
            </tr>
        </table>
    </div>
    <div id='home_post'>
        <div id="my_posts">
            POSTS 
        </div>
        <div id="content">

        </div>
    </div>
    <script>
        var post = new Post("select public_posts.*,civilian_detail.first_name,civilian_detail.last_name from public_posts inner join civilian_detail on public_posts.author=civilian_detail.NIC_num where public_posts.author='"+'<?php echo $viewer_nic?>'+"'");
        post.get_post();
    </script> 
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
</body>

</html>