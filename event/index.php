<?php  
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>view event</title>
        <link rel="stylesheet" href="/css_codes/view_event.css">
        <link rel="stylesheet" href="/css_codes/style.css">
        <link rel="stylesheet" href="/css_codes/help_request_popup.css">
        <script type="text/javascript" src="/js/request_help_popup.js"></script>
        <script type="text/javascript" src="/js/volunteer_application.js"></script>
    </head>
    <body>

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

                    <div id=help_btn>
                    </div>
                    
                    <div id=volunteer_btn>
                    </div>
                    <div >
                        <form action="view_my_individual_promises.php?event_id=<?php echo $_GET['event_id']?>" method=get>
                            <button id="indi_prom_btn" type='submit'>My Promises</button>
        	            </form>
                    </div>
                    
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
                        echo "<tr><td class='view_event_td'>" . ucfirst('Name') . "</td><td id=column2>" . ucfirst($result['name']) . "</td></tr>";
                        echo "<tr><td class='view_event_td'>" . ucfirst('Name') . "</td><td id=column2>" . ucfirst($result['name']) . "</td></tr>";
                        echo "<tr><td class='view_event_td'>" . ucfirst('Affected districts') . "</td><td id=column2>" . ucfirst($result['affected_districts']) . "</td></tr>";
                        echo "<tr><td class='view_event_td'>" . ucfirst('Start date') . "</td><td id=column2>" . ucfirst($result['start_date']) . "</td></tr>";
                        echo "<tr><td class='view_event_td'>" . ucfirst('End date') . "</td><td id=column2>" . ucfirst($result['end_date']) . "</td></tr>";
                        echo "<tr><td class='view_event_td'>" . ucfirst('Status') . "</td><td id=column2>" . ucfirst($result['status']) . "</td></tr>";
                        echo "<tr><td class='view_event_td'>" . ucfirst('Deaths and damages') . "</td><td id=column2>" . ucfirst($result['detail']) . "</td></tr>";
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
        </div>
        <div class='div1 popup' id='popup_div'>
        </div>
        <div id='overlay'>
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
    
        <script src='/event/view_event.js'></script>
    </body>
</html>