<?php
ob_start();
ignore_user_abort();
?>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/includes/header.php"; ?>

<link rel="stylesheet" href='/css_codes/fundraising_edit_img.css'>
<?php
    $id = intval($_GET['id']);
    $query = "select * from fundraisings where id=" . $id;
    $result = ($con->query($query))->fetch_assoc();

    if($result['by_civilian']  != $_SESSION['user_nic']){

        header("location:".(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :"/fundraising/"));
        ob_end_flush();
        ob_flush();
        flush();
    }

    $id = $result['id'];
    $fundraising_name = $result['name'];
    $imgs = array_filter(explode(',', $result['img']));
?>
<div class='fund_head' colspan=2><?php echo $fundraising_name ?></div>
<div class="img_cont">
    <div class='fund_image_conatainer'>
        <div class='img_type'>Profile Image</div>
        <div class="fund_image prim">
            <img src="/common/documents/Fundraising/<?php echo $id ?>.jpg" alt="Opps..." class="fund_pic">
        </div>
        <form method='post' action="/common/documents/upload.php" enctype="multipart/form-data">
            <input type=file name=upload_file accept="image/jpeg" style="display:none" onchange="this.parentElement.submit()">
            <input type=hidden name="directory" value="Fundraising/">
            <input type=hidden name="filename" value="<?php echo $id ?>">
            <input type=hidden name="header" value="true">
            <input type=hidden name="resize" value="true">
        </form>
        <button class='edit_profile_btn' onclick="this.previousElementSibling.firstElementChild.click()"><i class="fa fa-camera" aria-hidden="true"></i>Change</button>
    </div>
        <?php
        foreach ($imgs as $img) {?>
            <div class="fund_image_conatainer"> 
                <div class='img_type'>Secondary Images</div>
                <div class="fund_image seco">
                    <img src="/common/documents/Fundraising/secondary/<?php echo $img ?>.jpg" alt="Opps..." class="fund_pic">
                </div>
                <form method='post' action="/common/documents/upload.php" enctype="multipart/form-data">
                    <input type=file name=upload_file accept="image/jpeg" style="display:none" onchange="this.parentElement.submit()">
                    <input type=hidden name="directory" value="Fundraising/secondary/">
                    <input type=hidden name="filename" value="<?php echo $img ?>">
                    <input type=hidden name="header" value="true">
                </form>
                <button class='edit_profile_btn' onclick="this.previousElementSibling.firstElementChild.click()"><i class="fa fa-camera" aria-hidden="true"></i>Change</button>
                <form method='post' action="/common/documents/Fundraising/secondary/upload_fundraising.php" enctype="multipart/form-data">
                    <input type='hidden' name="img" value='<?php echo $img ?>'>
                    <input type='hidden' name="fund_id" value="<?php echo $_GET['id'] ?>">
                    <button class='remove_profile_btn' type='submit' name='delete' value='1'><i class="fas fa-trash-alt"></i>Remove</button>
                </form>
                
            </div>
        <?php }
        ?>
    <div class='new_photo_container'>
        <form method='post' action="/common/documents/Fundraising/secondary/upload_fundraising.php" enctype="multipart/form-data">
            <input type=file name=upload_file accept="image/jpeg" style="display:none" onchange="this.parentElement.submit()">
            <input type='hidden' name="fund_id" value="<?php echo $_GET['id'] ?>">
            <input type='hidden' name="upload" value="1">
        </form>
        <button id='upload_profile_btn' onclick="this.previousElementSibling.firstElementChild.click()"><i class="fa fa-camera" aria-hidden="true"></i>Upload new photo</button>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/includes/footer.php" ?>