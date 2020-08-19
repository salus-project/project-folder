<?php  
    session_start();
    require 'dbconfi/confi.php';
    require "header.php";
?>
<!DOCTYPE html>

<html>
    <head>
        <title>view event</title>
        <link rel="stylesheet" href="css_codes/view_event.css">
    </head>
    <body>
        <?php
            $query="select * from disaster_events where event_id =" . $_GET['event_id'];
            $result=($con->query($query))->fetch_assoc();
            $event_status=$result['status'];
            $event_id=$result['event_id'];
        ?>
        
        <div id=event_header>
            <div id=title_box>
                <?php echo $result['name'] ?>
            </div>
            <div class='edit_close_btn_div'>
            <?php
                echo "<form action=edit_event.php method=GET>";
                echo    "<button type='submit' name=event_id class='edit_button' value=".$event_id."><i class='fa fa-pencil-square-o' style='font-size:20px;color:black;' aria-hidden='true'>Edit</i></button>";
                echo "</form>";
                if($event_status==="active"){
                    echo "<form action=close_event.php method=GET>";
                    echo    "<button type='submit' name=close class='close_button' value=".$event_id."><i class='fa fa-window-close' style='font-size:20px;color:black;' aria-hidden='true'>Close</i></button>";
                    echo "</form>";
                }
            ?>
            </div>
        </div>
        <div class='detail_body'>
            <div class='table_container'>
                <table class='event_table'>
                    <tr>
                        <th colspan=2>
                            Event Detail
                        </th>
                    </tr>
                    <?php
                        foreach($result as $x=>$y){
                            if((ucfirst($x)!="GeoJson" and ucfirst($x)!="Event_id") and (ucfirst($x)=="Name" or ucfirst($x)=="Type" 
                            or ucfirst($x)=="Affected_districts" or ucfirst($x)=="Start_date" or ucfirst($x)=="End_date" or ucfirst($x)=="Status" or ucfirst($x)=="Detail") ){
                                echo "<tr><td>" . ucfirst($x) . "</td><td >" . ucfirst($y) . "</td></tr>";
                            }
                        }
                    ?>
                </table>
            </div>
            <div class='table_container'>
                <table class='event_table'>
                    <tr>
                        <th colspan=2>
                            Civilian Status Detail
                        </th>
                    </tr>
                    <?php
                        foreach($result as $x=>$y){
                            if((ucfirst($x)!="GeoJson" and ucfirst($x)!="Event_id" and ucfirst($x)!="Name" and ucfirst($x)!="Type" 
                            and ucfirst($x)!="Affected_districts" and ucfirst($x)!="Affected_no" and ucfirst($x)!="Start_date" and ucfirst($x)!="End_date" and ucfirst($x)!="Status" and ucfirst($x)!="Detail") ){
                                echo "<tr><td>" . ucfirst($x) . "</td><td >" . ucfirst($y) . "</td></tr>";
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>

