<?php  
    require $_SERVER['DOCUMENT_ROOT']."/staff/header.php";
?>
<link rel="stylesheet" href='/staff/css_codes/view_event.css'>
<?php
    $id = intval($_GET['id']);
    $query = "select * from disaster_events where event_id=" . $id;
    $result = ($con->query($query))->fetch_assoc();

    /*if($result['by_civilian']  != $_SESSION['user_nic']){

        header("location:".(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :"/fundraising/"));
        ob_end_flush();
        ob_flush();
        flush();
    }*/

    $id = $result['event_id'];
    $event_name = $result['name'];
    $imgs = array_filter(explode(',', $result['img']));
?>
<div class='fund_head' colspan=2><?php echo $event_name ?></div>
<div class="img_cont">
        <?php
        foreach ($imgs as $img) {?>
            <div class="fund_image_conatainer">
                <div class="fund_image seco">
                    <img src="http://d-c-a.000webhostapp.com/Event/<?php echo $img ?>.jpg" alt="Opps..." class="fund_pic">
                </div>
                <form method='post' action="http://d-c-a.000webhostapp.com/upload.php" enctype="multipart/form-data">
                    <input type=file name=upload_file accept="image/jpeg" style="display:none" onchange="this.parentElement.submit()">
                    <input type=hidden name="directory" value="Event/">
                    <input type=hidden name="filename" value="<?php echo $img ?>">
                    <input type=hidden name="header" value="true">
                </form>
                <button class='edit_profile_btn' onclick="this.previousElementSibling.firstElementChild.click()"><i class="fa fa-camera" aria-hidden="true"></i>Change</button>
                <button class='remove_profile_btn' type='submit'><i class="fas fa-trash-alt"></i>Remove</button>
            </div>
        <?php }
        ?>
    <div class='new_photo_container'>
        <form method='post' action="http://d-c-a.000webhostapp.com/Fundraising/secondary/upload_fundraising.php" enctype="multipart/form-data">
            <input type=file name=upload_file accept="image/jpeg" style="display:none" onchange="this.parentElement.submit()">
            <input type=hidden name="fund_id" value="<?php echo $_GET['id'] ?>">
        </form>
        <button id='upload_profile_btn' onclick="this.previousElementSibling.firstElementChild.click()"><i class="fa fa-camera" aria-hidden="true"></i>Upload new photo</button>
    </div>
</div>
