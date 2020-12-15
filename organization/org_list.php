<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
?>

<div id='event_overlay' onclick='remove(this)'></div>
<div class="org_php_container">
    <div class='org_table_con'>
        <form method='get' action='/organization'>
            <table id="org_header_table">
                <div class=view_all>ORGANIZATIONS</div><button class='org_setting_btn' type=button><i class='fa fa-cog'  aria-hidden='true'></i></button>
                <div class='hidden_org_div'>
                    <a href="/organization/all_org.php"><button type=button class='org_name view_all_btn'>View all</button></a>
                    <a href="/organization/create_organization"><button type="button" class='org_name create_org_btn'>Create new organization</button></a>
                </div>

                <?php
                    $org_detail=$con->query('select org_name,org_id from organizations');
                    while($row=$org_detail->fetch_assoc()){
                        echo "<tr><td class='name_td'><button class='org_name' type='submit' name='selected_org' value='".$row['org_id']."'><div><img src='/common/documents/Organization/Profiles/resized/".$row['org_id'].".jpg'></div>".$row['org_name']."</button</td></tr>";
                    }
                ?>
            </table>
        </form>
    </div>
</div>
