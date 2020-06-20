<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
?>

<link rel="stylesheet" href="/css_codes/organizations.css">
<div id='event_overlay' onclick='remove(this)'></div>
<div id="detail_body">
    <form method='get' action='/organization'>
        <table id="table">
            <thead>
                <th id="no"><a href="/organization/create_organization"><button type="button" class='create_org_btn'>Create new organization</button></a></th>
            </thead>
            <?php
                $org_detail=$con->query('select org_name,org_id from organizations');
                while($row=$org_detail->fetch_assoc()){
                    echo "<tr><td class='name_td'><button class='org_name' type='submit' name='selected_org' value='".$row['org_id']."'>".$row['org_name']."</button</td></tr>";
                }
            ?>
        </table>
    </form>
</div>