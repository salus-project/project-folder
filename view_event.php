<?php  
    session_start();
    require 'dbconfi/confi.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <title>view event</title>
        <link rel="stylesheet" href="css_codes/view_event.css">
    </head>
    <body>
        
        <?php require "header.php" ?>

        <script>
            btnPress(4);
        </script>
        <?php
            $query="select * from disaster_events where event_id =" . $_GET['event_id'];
            $result=($con->query($query))->fetch_assoc();
            
            $status=explode(" ",$result['user_'.$_SESSION['user_nic']]);

            $org_query = "select * from organizations where leader = '" . $_SESSION['user_nic'] . "' OR co_leader = '" . $_SESSION['user_nic'] . "'";
            $all_organizations = $con->query($org_query);
            $organization=array();
            if($all_organizations){
                while($org=$all_organizations->fetch_assoc()){
                    array_push($organization,$org);
                }
            }
            $js_organization = json_encode($organization);

        ?>
        <div id=event_header>
            <div id=title_box>
                <?php echo $result['name'] ?>
                <div id=status>
                    <div id=safe_btn>

                    </div>

                    <input type=hidden name=event_id value=<?php echo $_GET['event_id']?>>
                    <div id=help_btn>
                    </div>
                    
                    <form method=get action=volunteer_application.php>
                    <input type=hidden name=event_id value=<?php echo $_GET['event_id']?>>
                        <div id=volunteer_btn>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <div id=detail_body>
            <div id='table_caontainer'>
                <table id=table>
                    <thead>
                        <th colspan=2>
                            Event Detail
                        </th>
                    </thead>
                    <?php
                        foreach($result as $x=>$y){
                            echo "<tr><td id=column1>" . ucfirst($x) . "</td><td id=column2>" . ucfirst($y) . "</td></tr>";
                        }
                    ?>
                </table>
            </div>
            <div id=news_field>
                Goverment posts and announcements about this event
            </div>
            
        </div>
        <div id=pictures>
            <h3>Photos</h3>
        </div>
        <div id=social_events>
            <div id=help_requested>
                <h2>Help requested people<h2>
                <table>
				<?php
					$query1='select NIC_num,first_name,last_name from civilian_detail';
					$result1=$con->query($query1);
					while($civilian=$result1->fetch_assoc()){
                        $nic_num=$civilian["NIC_num"];
                        $help_request_status= explode(" ",$result['user_'.$nic_num])[1];
                        if ($help_request_status=='requested') {
                            $full_name=$civilian["first_name"].' '.$civilian["last_name"];
                            echo "<tr>";
                            echo    "<td id=data>";
                            echo        "<form method=get action=sample.php>";
                            echo            "<input type=hidden name='to' value=".$civilian['NIC_num'].">";
                            echo            "<div class='requested' onclick='help_option(this)'>";
                            echo                $full_name;
                            echo            "</div>";
                            echo        "</form>";
                            echo    "</td>";
                            echo "</tr>";
                        }
					}
				?>
				</table>
            </div>
            <div id=affected>
                <h2>Affected people detail</h2>
            </div>
            <div id=organizations>
                <h2>Organizations on action</h2>
            </div>

        <script>
            var safe_status = '<?php echo $status[0]?>';
            var help_status = '<?php echo $status[1]?>';
            var volunteer_status = '<?php echo $status[2]?>';

            var event_id='<?php echo $result['event_id'] ?>';
            var nic_num = '<?php echo $_SESSION['user_nic']?>';
            var organization = <?php echo $js_organization ?>;
            var district_in_nic = '<?php echo $_SESSION['district'] ?>';
        </script>
        </div>
        <?php require 'request_help_popup.html' ?>
    
        <script src='view_event.js'></script>
    </body>
</html>