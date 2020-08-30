<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    $query="select org_name,org_id,LOWER(district),discription from organizations ORDER BY district, org_name;
    select organizations.org_name,organizations.org_id,role from org_members inner join organizations on org_members.org_id = organizations.org_id where org_members.NIC_num='".$_SESSION['user_nic']."' order by case when role = 'leader' then '1' when role = 'coleader' then '2' else role end asc;";
    
    if(mysqli_multi_query($con, $query)){
        $sql_result = mysqli_store_result($con);
        $result = mysqli_fetch_all($sql_result,MYSQLI_ASSOC);
        mysqli_free_result($sql_result);
    }
    mysqli_next_result($con);
    $sql_result = mysqli_store_result($con);
    $my_org_detail = mysqli_fetch_all($sql_result,MYSQLI_ASSOC);
    mysqli_free_result($sql_result);

?>

<link rel="stylesheet" href="/css_codes/all_org.css">
<div id="org_body">
    <form method='get' action='/organization'>
        <div class='top'>
            <div class='cont'>
                <div class='org_search'>
                    <div>Search for: </div><div class='search'><input id='search_org' placeholder='Enter Organization name' class='search_input' type=text></div>
                </div>
                <div id='create_org'>
                    <thead>
                        <a href='/organization/create_organization'><button type='button' class='create_but'>Create new organization</button></a>
                    </thead>
                </div>
            </div>
        </div>
        <div  class="org_div">
            <div  class="org_role_div">
                <table id="org_table">
                    <tr>
                        <th class="dis_name">My Organizations</th>
                    </tr>
                    <?php
                    foreach($my_org_detail as $my_org){
                        echo "<tr><td class='table_td org_list'>
                            <div class='org_main'>
                                <div class='org_logo_container'>";
                                    $org_profile_path =" http://d-c-a.000webhostapp.com/Organization/Profiles/" . $my_org['org_id'] . ".jpg";
                                    echo '<img src="<?php echo $org_profile_path;?>" alt="Opps..." class="org_logo_pic">
                                </div>
                                <div class="org_name_des">
                                    <button class="org_name_btn" type="submit" name="selected_org" value="'.$my_org['org_id'].'">'.$my_org['org_name'].'<br>'.$my_org['role'].'</button>
                                </div>
                                </td>
                            </tr>';
                    }
                    ?>
                </table>
            </div>
        <div class="org_table_div">
        <table id="org_table">
            <?php
                
                $districts = array_unique(array_column($result,'LOWER(district)'));
                
                foreach($districts as $row_dis){
                    echo "<tr><td class='table_td dis_name'>". ucfirst($row_dis) . "</td></tr>";
                    innerOrg($row_dis,$result);
                }

                function innerOrg($dis,$result){
                    $org_array = array_filter(array_map(function($item) use($dis) {return org_filter($item,$dis);},$result));
                    $orgs = array_map(function($item){return array(($item['org_name']),$item['org_id'],$item['discription']);},$org_array);
                    foreach($orgs as $org){
                        echo "<tr><td class='table_td org_list'>
                            <div class='org_main'>
                                <div class='org_logo_container'>";
                                    $org_profile_path =" http://d-c-a.000webhostapp.com/Organization/Profiles/" . $org[1] . ".jpg";
                                    echo '<img src="<?php echo $org_profile_path;?>" alt="Opps..." class="org_logo_pic">
                                </div>
                                <div class="org_name_des">
                                    <button class="org_name_btn" type="submit" name="selected_org" value="'.$org[1].'">'.ucfirst($org[0]).'<br>'.$org[2].'</button>
                                </div>
                                </td>
                            </tr>';
                    }
                }
                function org_filter($row,$org){
                    if($row['LOWER(district)'] == $org){
                        return $row;
                    }
                }
                function countOrg($dis,$result){
                    $org_array = array_filter(array_map(function($item) use($dis) {return org_filter($item,$dis);},$result));
                    $orgs = array_map(function($item){return array(($item['org_name']),$item['org_id']);},$org_array);
                    return count($orgs)+1;
                }
                 
            ?>
        </table>
            </div>
            </div>
    </form>
</div>
<script>
    autocomplete_ready(document.getElementById("search_org"), 'orgs', 'ready', 'click');
</script>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>