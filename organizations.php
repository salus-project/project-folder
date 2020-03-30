<?php
    session_start();
    require 'dbconfi/confi.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Organizations</title>
        <link rel="stylesheet" href="css_codes/organizations.css">
    </head>
    <body>
        <?php require 'header.php'; ?>
        
        <div id="header">
            Organization list
        </div>
        <div id="detail_body">
            <a href="create_org.php"><button>Create new organization</button></a>
            <form method='get' action='view_org.php'>
                <table id="table">
                    <thead>
                        <th id="no">No</th>
                        <th id="name">Organization name</th>
                    </thead>
                    <?php
                        $num=1;
                        $org_detail=$con->query('select org_name,org_id from organizations');
                        while($row=$org_detail->fetch_assoc()){
                            //echo "<input type='hidden' name='selected_org' value=" . $row['org_id'] . ">";
                            echo "<tr><td>" .$num."</td><td id='name_td'><button id='org_name' type='submit' name='selected_org' value='".$row['org_id']."'>".$row['org_name']."</button</td></tr>";
                            $num++;
                        }
                        /*if($_SERVER['REQUEST_METHOD']=='GET'){
                            $org_detail=$con->query('select org_name,org_id from organizations');
                            while($row=$org_detail->fetch_assoc()){
                                if(isset($_GET[$row['org_id']])){
                                    $_GET['selected_org']=$row['org_id'];
                                    //header('location:view_org.php');
                                }
                            }
                        }*/
                    ?>
                </table>
            </form>
        </div>
    </body>

</html>