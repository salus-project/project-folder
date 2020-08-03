<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>
<link rel="stylesheet" href="/css_codes/organizations.css">
<div id="org_body">
    <form method='get' action='/organization'>
        <div class='top'>
            <div class='cont'>
                <div class='org_search'>
                    <div>Search for: </div><div class='search'><input placeholder='Organization name' class='search_input' type=text></div>
                </div>
                <div id='create_org'>
                    <thead>
                        <a href='/organization/create_organization'><button class='create_but'>Create new organization</button></a>
                    </thead>
                </div>
            </div>
        </div>
        <table id="table">
            <?php
                $org_detail=$con->query('select org_name,org_id,LOWER(district),discription from organizations ORDER BY district, org_name');
                $result=$org_detail->fetch_all(MYSQLI_ASSOC);
                
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
                                    <button class="org_name" type="submit" name="selected_org" value="'.$org[1].'">'.ucfirst($org[0]).'<br>'.$org[2].'</button>
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
    </form>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>