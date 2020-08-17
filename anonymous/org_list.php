<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
?>

<div id='event_overlay' onclick='remove(this)'></div>
<div class="org_php_container">
    <div class='org_table_con'>
        <form method='get' action='/organization'>
            <table id="org_header_table">
                <div class=view_all>ORGANIZATIONS</div><button class='org_setting_btn' type=button><i class='fa fa-cog'  aria-hidden='true'></i></button>
                <div class='hidden_org_div'>
                    <a href="/anonymous/all_org.php"><button type=button class='org_name view_all_btn'>View all</button></a>
                </div>

                <?php
                    $org_detail=$con->query('select org_name,org_id from organizations');
                    while($row=$org_detail->fetch_assoc()){
                        echo "<tr><td class='name_td'><button class='org_name' type='submit' name='selected_org' value='".$row['org_id']."'>".$row['org_name']."</button</td></tr>";
                    }
                ?>
            </table>
        </form>
    </div>
</div>