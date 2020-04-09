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
                    <form>
                        <div id=safe_btn>
                        </div>
                    </form>
                    <form method=get action=request_help.php>
                        <input type=hidden name=event_id value=<?php echo $_GET['event_id']?>>
                        <div id=help_btn>
                        </div>
                    </form>
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
                        $help_request_status= explode(" ",$result[$nic_num])[1];
                        if ($help_request_status=='requested') {
                            $full_name=$civilian["first_name"].' '.$civilian["last_name"];
                            echo "<tr>";
                            echo    "<td id=data>";
                            echo        "<form method=get action=sample.php>";
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
    <script>
        var safe_status = '<?php echo $status[0]?>';
        var help_status = '<?php echo $status[1]?>';
        var volunteer_status = '<?php echo $status[2]?>';

        var event_id='<?php echo $result['event_id'] ?>';
        var nic_num = '<?php echo $_SESSION['user_nic']?>';

        switch(safe_status){
            case 'not_set':
                var html1 = "<button id='mark' onclick='markFun()'>Mark</button>";
        }
        var safe_btn = document.getElementById('safe_btn');
        safe_btn.innerHTML = html1;

        switch(help_status){
            case 'not_requested':
                var html2 = "<button type=submit id='request_help' name=method value=request>Request help</button>";
                break;

            case 'requested':
                var html2 =     "<button id='help_request_option' disabled>Help Requested</button>" +
                                "<div id=changeRequest>"+
                                    "<button id=drop_dwn name=method value=cancel>Cancel Request</button><br>"+
                                    "<button id=drop_dwn name=method value=option>Request Option</button>"+
                                "</div>";
                break;
        }
        var help_btn = document.getElementById('help_btn');
        help_btn.innerHTML = html2;

        switch(volunteer_status){
            case 'not_applied':
                var html3 = "<button id='volunteer' name=method value=apply>Help others</button>";
                break;
            case 'applied':
                var html3 =     "<button id='volunteer_option' name=event_id disabled>Volunteer Option</button>"+
                                "<div id=changeVolunteer>"+
                                    "<button id='drop_dwn' name=method value=cancel>leave volunteer</button><br>"+
                                    "<button id='drop_dwn'name=method value=option>Volunteer Option</button>"+
                                "</div>";
                break;
        }
        var volunteer_btn = document.getElementById('volunteer_btn');
        volunteer_btn.innerHTML = html3;

        function markFun(){
            html1="<div class=switch_container><form method=post action=view_event.php><label class='switch'><input type=checkbox id=checkbox onclick=markingFun()><span class=slider></span></label><span class=indicator id=indicator>Safe</span><input  type=submit id=submit_btn value=submit></form></div>";
            status_btn.innerHTML = ( html1 + html2 + html3 );
            status='safe';
            update();
        }
        function markingFun(){
            var checkbox = document.getElementById('checkbox');
            if(checkbox.checked){
                status='not_safe';
                update();
            }else{
                status='safe';
                update();
            }
        }
        /*var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password:"",
            database:"project_db"
        });*/
        function update(){
            con.connect(function(err){
                if(err) throw err;
                console.log('connected');
                var sql = "update civilian_status set event_"+event_id+" = "+status+" where nic_num="+nic_num;
                con.query(sql,function(err,result){
                    if(err) throw err;
                    console.log("updated")
                });
            });
        }

        var organization = <?php echo $js_organization ?>;
        var help_people_html='<div id=requested_container>';
        if(volunteer_status=='applied'){
            help_people_html +=  "<button >Help Yourself </button></br>"
        }
        for(org in organization){
            help_people_html += "<button >Help with </button></br>";
        }
        help_people_html +='</div>';
        var requested = document.getElementsByClassName('requested');
        for(div in requested){
            requested[div].innerHTML += help_people_html;
        }
        function help_option(element){
            var inner = element.querySelector('#requested_container');
            if(inner.style.display=='' || inner.style.display=='none'){
                inner.style.display = 'block';
            }else if(inner.style.display == 'block'){
                inner.style.display = 'none';
            }
        }
        
    </script>
    </body>
</html>