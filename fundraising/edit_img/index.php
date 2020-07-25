<?php 
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>
<link rel="stylesheet" href='/css_codes/fundraising_edit_img.css'>
<?php
    $id=intval($_GET['id']);
    $query="select * from fundraisings where id=".$id;
    $result=($con->query($query))->fetch_assoc();

    $id=$result['id'];
    $fundraising_name=$result['name'];
    $imgs=array_filter(explode(',',$result['img']));

    echo '<div class="img_cont">
        <div class="fund_image prim">
            <img src="http://d-c-a.000webhostapp.com/FUndraising/'.$id .'.jpg" alt="Opps..." class="fund_pic">
        </div>';

        foreach($imgs as $img){
            echo '<div class="fund_image seco">
                    <img src="'.$img.'.jpg" alt="Opps..." class="fund_pic">
                </div>';
        }
    echo "</div>";
    ?>

<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>