<?php
require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php";

$event_id = $_GET['event_id'];
$nic = $_GET['nic'];
$query = "select * from event_" . $event_id . "_help_requested where NIC_num='" . $nic . "';
    select first_name, last_name from civilian_detail where NIC_num='" . $nic . "';
    select * from event_" . $event_id . "_requests where requester='" . $nic . "';
    select org.org_id, org.org_name, org_members.role from org_members inner join organizations as org on org_members.org_id=org.org_id where org_members.NIC_num = '" . $_SESSION['user_nic'] . "' and ( org_members.role='leader' or org_members.role='coleader');
    select `user_" . $_SESSION['user_nic'] ."` from disaster_events where event_id=".$event_id.";";

if (mysqli_multi_query($con, $query)) {
    $result = mysqli_store_result($con);
    $requester_detail = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    mysqli_next_result($con);
    $result = mysqli_store_result($con);
    $civilian_detail = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    mysqli_next_result($con);
    $result = mysqli_store_result($con);
    $requests = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    mysqli_next_result($con);
    $result = mysqli_store_result($con);
    $orgs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    mysqli_next_result($con);
    $result = mysqli_store_result($con);
    $status = explode(' ', mysqli_fetch_row($result)[0])[2];
    mysqli_free_result($result);
    $content = '';
    foreach ($requests as $row) {
        $content .= $row['item'] . " : " . $row['amount'] . "<br>";
    }
}
$name = $civilian_detail['first_name'] . " " . $civilian_detail['last_name'];
?>
<!DOCTYPE html>
<html>

<head>
    <link rel='stylesheet' href='/css_codes/requester.css'>
</head>
<style>
    #main_container{
        width:400px;
        margin: auto;
        border: 1px solid black;
        margin-top: 10%;
        background-color: white;
    }
    .requester_button{
        display: inline-block;
        width: 115px;
        height: 35px;
        background: #9b9b9b;
        padding: 5px;
        text-align: center;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        line-height: 25px;
    }
    .requester_button_subcontainer{
        position: relative;
        display: inline-block;
    }
    .dropdown_org_container{
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }
    .org_drop{
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .org_drop:hover{background-color: #ddd;}
    .requester_button_subcontainer:hover .dropdown_org_container{display: block;}
    .requester_button_subcontainer:hover .org_drop{background-color: #3e8e41;}
</style>

<body>
    <script>
        btnPress(4);
    </script>
    <div id='main_container'>
        <div id='requester_div'>
            <table id='requester_tab'>
                <tr>
                    <td colspan='2' id='requester_head'><b>Request Details of <?php echo "<a href='/view_profile.php?id=" . $requester_detail['NIC_num'] . "'>" .
                                                                                    $name . "</a>"; ?></b></td>
                </tr>
                <tr>
                    <td class='request_col1'>District(current):</td>
                    <td class='request_col2'><?php echo $requester_detail['district']; ?></td>
                </tr>
                <tr>
                    <td class='request_col1'>Village:</td>
                    <td class='request_col2'><?php echo $requester_detail['village']; ?></td>
                </tr>
                <tr>
                    <td class='request_col1'>Street:</td>
                    <td class='request_col2'><?php echo $requester_detail['street']; ?></td>
                </tr>
                <tr>
                    <td class='request_col1'>Requests:</td>
                    <td class='request_col2'><?php echo $content; ?></td>
                </tr>
            </table>
        </div>
        <div id='requester_button_container'>
            <div class='requester_button_subcontainer'>
                <div class='requester_button'>Help</div>
                <div id='dropdown_org_container' class='dropdown_org_container'>
                    <?php
                        if($status!='applied'&& count($orgs)==0){?>
                            <div class='org_drop'>
                                Create an organization or join as Volunteer to help
                            </div>
                <?php   }else{
                            if($status!='applied'){?>
                                <a href="/event/help?event_id=<?php echo $event_id ?>&to=<?php echo $nic ?>&by=<?php echo $_SESSION['user_nic'] ?>">
                                    <div class="org_drop">
                                        Behalf of Yourself
                                    </div>
                                </a>
                    <?php   }
                            foreach($orgs as $org){?>
                                <a href="/event/help?event_id=<?php echo $event_id ?>&to=<?php echo $nic ?>&by=<?php echo $org['org_id'] ?>">
                                    <div class="org_drop">
                                        <?php echo $org['org_name']." (".$org['role'].")" ?>
                                    </div>
                                </a>
                <?php       }
                        }
                    ?>
                </div>
            </div>
            <a href='<?php echo $_SERVER['HTTP_REFERER'] ?>'><div class='requester_button'>Back</div></a>
        </div>
    </div>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>