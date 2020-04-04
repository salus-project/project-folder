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
            $status_query = "select event_".$result['event_id']." from civilian_status where nic_num = '".$_SESSION['user_nic']."'";
            $status=(($con->query($status_query))->fetch_assoc())["event_".$result['event_id']];
        ?>
        <div id=event_header>
            <div id=title_box>
                <?php echo $result['name'] ?>
                <div id=status>
                    
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
            <div id=affected>
                <h2>Affected people detail
            </div>
            <div id=help_requested>
                <h2>Help requested people<h2>
            </div>
            <div id=organizations>
                <h2>Organizations on action</h2>
            </div>
        </div>
    <script>
        var status_btn = document.getElementById('status');
        var status = '<?php echo $status?>';
        var event_id='<?php echo $result['event_id'] ?>';
        var nic_num = '<?php echo $_SESSION['user_nic']?>';
        switch(status){
            case 'not_set':
                var html = "<button id='mark' onclick='markFun()'>Mark</button>";
                status_btn.innerHTML = html;
        }
        function markFun(){
            var html="<div class=switch_container><form method=post action=view_event.php><label class='switch'><input type=checkbox id=checkbox onclick=markingFun()><span class=slider></span></label><span class=indicator id=indicator>Safe</span><input  type=submit id=submit_btn value=submit></form></div>";
            status_btn.innerHTML=html;
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
        var mysql = require('mysql');
        var con = mysql.createConnection({
            host: "localhost",
            user: "root",
            password:"",
            database:"project_db"
        });
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
        
    </script>
    </body>
</html>