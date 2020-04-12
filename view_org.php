<?php
    session_start();
    require 'dbconfi/confi.php';
    $query="select * from organizations where org_id=".$_GET['selected_org'];
    $result=($con->query($query))->fetch_assoc();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>view organization</title>
        <link rel="stylesheet" href='css_codes/view_org.css'>
    </head>
    <body>
        <?php require 'header.php' ?>
        <script>
            btnPress(6);
        </script>
        <div id=org_title>
            <div id=title_margin>
                <div id=org_logo>
                    <div style="height:1px;width:1px">
                    <img id=logo src=org_logos/default.png style="z-index:2;">
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
                    ?>
					
					
                </div>
                <div id=discription>
                    <h4 id=org_detail><?php echo $result['discription'] ?></h4>
                </div>
            </div>
        </div>
        <div id='org_body'>
					<div id=chat_btn_container>
                    <form action=chat.php method=get>
						<button id=chat_btn type='submit' name=chat value=".$_GET['selected_org'].">Group chat</button>
					</form>
					</div>
            <table>
                <tr>
                    <td>leader</td>
                    <td><?php echo $result['leader'] ?></td>
                </tr>
                <tr>
                    <td>District</td>
                    <td><?php echo $result['district'] ?></td>
                </tr>
                <tr>
                    <td>Contact email</td>
                    <td><?php echo $result['email'] ?></td>
                </tr>
                <tr>
                    <td>Contact number</td>
                    <td><?php echo $result['phone_num'] ?></td>
                </tr>
            </table>
        </div>
        
    </body>

</html>