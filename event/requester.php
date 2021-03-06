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

<body>
    <script>
        btnPress(4);
    </script>
    <div class='main_container'>
        <div class='requester_div'>
            <div class='requester_head'>
                <span class="requester_inner_head">Requester Details</span>
                <div class="req_requester_detail_cont">
                    <a class='name_anchor' href='/view_profile.php?id=<?php echo $requester_detail['NIC_num'] ?>'>
                        <img src="/common/documents/Profiles/resized/<?php echo $requester_detail['NIC_num'] ?>.jpg" alt="opps" class="requester_img"/>
                        <?php echo $name ?>
                    </a>
                    <a id='send_message' href='/message/?to_person=<?php echo $requester_detail['NIC_num'] ?>'>
                        <i class='fas fa-comments'></i> message
                    </a>
                </div>
            </div>
            <table class="requester_detail_table">
                <tr>
                    <td class='request_col1'>District(current)</td>
                    <td class='request_col2'><?php echo $requester_detail['district']; ?></td>
                </tr>
                <tr>
                    <td class='request_col1'>Village</td>
                    <td class='request_col2'><?php echo $requester_detail['village']; ?></td>
                </tr>
                <tr>
                    <td class='request_col1'>Street</td>
                    <td class='request_col2'><?php echo $requester_detail['street']; ?></td>
                </tr>
                <tr>
                    <td class='request_col1'>Requests</td>
                    <td class='request_col2'><?php echo $content; ?></td>
                </tr>
            </table>
        </div>
        <div class='requester_button_container'>
            <div class='requester_button_subcontainer'>
                <div class='requester_button butn'>Help</div>
                <div id='dropdown_org_container' class='dropdown_org_container'>
                    <?php
                        if($status!='applied' && count($orgs)==0){?>
                            <div class='org_drop'>
                                Create an organization or join as Volunteer to help
                            </div>
                <?php   }else{
                            if($status=='applied'){?>
                                <a href="/event/help?event_id=<?php echo $event_id ?>&to=<?php echo $nic ?>&by=your_self">
                                    <div class="org_drop behalf_you">
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