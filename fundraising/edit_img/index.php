<?php require $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"; ?>

<link rel="stylesheet" href='/css_codes/fundraising_edit_img.css'>
<?php
    $id = intval($_GET['id']);
    $query = "select * from fundraisings where id=" . $id;
    $result = ($con->query($query))->fetch_assoc();

    $id = $result['id'];
    $fundraising_name = $result['name'];
    $imgs = array_filter(explode(',', $result['img']));
?>

<div class="img_cont">
    <div class='fund_image_conatainer'>
        <h3>Profile Image</h3>
        <div class="fund_image prim">
            <img src="http://d-c-a.000webhostapp.com/Fundraising/<?php echo $id ?>.jpg" alt="Opps..." class="fund_pic">
        </div>
        <form method='post' action="http://d-c-a.000webhostapp.com/upload.php" enctype="multipart/form-data">
            <input type=file name=upload_file accept="image/jpeg" style="display:none" onchange="this.parentElement.submit()">
            <input type=hidden name="directory" value="Fundraising/">
            <input type=hidden name="filename" value="<?php echo $id ?>">
            <input type=hidden name="header" value="true">
            <input type=hidden name="resize" value="true">
        </form>
        <button id='edit_profile_btn' onclick="this.previousElementSibling.firstElementChild.click()"><i class="fa fa-camera" aria-hidden="true"></i>Change</button>
    </div>

    <div class='fund_image_secondary_container'>
    <h3>Secondary Images</h3>
        <?php
        foreach ($imgs as $img) {?>
            <div class="fund_image_conatainer">
                <div class="fund_image seco">
                    <img src="http://d-c-a.000webhostapp.com/Fundraising/secondary/<?php echo $img ?>.jpg" alt="Opps..." class="fund_pic">
                </div>
                <form method='post' action="http://d-c-a.000webhostapp.com/upload.php" enctype="multipart/form-data">
                    <input type=file name=upload_file accept="image/jpeg" style="display:none" onchange="this.parentElement.submit()">
                    <input type=hidden name="directory" value="Fundraising/secondary/">
                    <input type=hidden name="filename" value="<?php echo $img ?>">
                    <input type=hidden name="header" value="true">
                </form>
                <button id='edit_profile_btn' onclick="this.previousElementSibling.firstElementChild.click()"><i class="fa fa-camera" aria-hidden="true"></i>Change</button>
            </div>
        <?php }
        ?>
    </div>
    <div class='new_photo_container'>
        <h3>Upload a new photo</h3>
        <form method='post' action="http://d-c-a.000webhostapp.com/Fundraising/secondary/upload_fundraising.php" enctype="multipart/form-data">
            <input type=file name=upload_file accept="image/jpeg" style="display:none" onchange="this.parentElement.submit()">
            <input type=hidden name="fund_id" value="<?php echo $_GET['id'] ?>">
        </form>
        <button id='edit_profile_btn' onclick="this.previousElementSibling.firstElementChild.click()"><i class="fa fa-camera" aria-hidden="true"></i>Upload</button>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php" ?>