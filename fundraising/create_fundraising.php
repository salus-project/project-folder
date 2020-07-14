<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";

    $fundraising_name=$org_name=$for_event=$for_any=$service_area=$description="";
    $query="select * from org_members where (role='leader' or role='coleader') and NIC_num='".$_SESSION['user_nic']."';
    select * from disaster_events;";
    if(mysqli_multi_query($con,$query)){
        $result = mysqli_store_result($con);
        $org_result = mysqli_fetch_all($result,MYSQLI_ASSOC);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $event_name_result = mysqli_fetch_all($result,MYSQLI_ASSOC);
        mysqli_free_result($result);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Create new fundraising event</title>
        <link rel="stylesheet" href="/css_codes/create_fundraising.css">
    </head>
    <body>

        <script>
            btnPress(7);
        </script>
        <form method='POST' action='/fundraising/create_fundraising_php.php'>
        <div id="main_fund_form_body">
            <center><h2>Create a new fundraising event</h2></center>
            <small style="margin:10px;">Enter the details</small>
            <table id='sub_fund_form_body'>
                <tr>
                    <td colspan='2'>
                        <span id='error'>* required field</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='fundraising_name'>Fundraising event name</label>
                    </td>
                    <td>
                        <input type='text' id="fun_name" name="fundraising_name" value=<?php echo $fundraising_name; ?>>
                        <span id='error' class="error">* </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='organization'>Select organization</label>
                    </td>
                    <td>
                        <select name="organization" id="org_id">
                            <option value=''>Not organization based</option>
                            <?php                       
                                foreach($org_result as $row){
                                    echo "<option value=" . $row["org_id"] . ">" . $row["org_name"] . "</option>";
                                }
                            ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='event'>Select purpose</label>
                    </td>
                    <td>
                        <input type="hidden" id="purp" name="purp" value="00" />
                        <input type='radio' name="purpose" value=''  onclick='purposeFun()'>For event<br>
                        <select name="for_event" id="for_event"  style='display:none'>
                            <?php
                                foreach($event_name_result as $row){
                                    echo "<option value=" . $row["event_id"] . ">" . $row["name"] . "</option>";
                                }
                            ?>
                            <div style="display:flex; height:20px;">
                                <input type='radio' name="purpose" id='other_purpose_opt' value=''  onclick='purposeFun()'>Other purpose
                                <input type='text' name='other_purpose' id='other_purpose' style='display:none' value=<?php echo $for_any; ?>>
                            </div>

                            <span id='error' class="error">* </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for='type'>Your Expectations</label>
                    </td>
                    <td>
                        <div class="input_container" id=add_i >
                            <div class="input_sub_container">
                                <input type="text" class="text_input" name="item[]" placeholder="item">
                                <input type="text" class="text_input" name="amount[]" placeholder="amount">
                                <button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Service area</label>
                    </td>
                    <td>
                        <input type='text' name="service_area" id="service_area" value=<?php echo $service_area; ?>>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Description</label>
                    </td>
                    <td>
                        <textarea name='description' id="description" ><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <input type="submit" name="submitBtn" id='submitBtn' value="SUBMIT"></button>
                    </td>
                </tr>
            </table>

        </div>
        </form>
    </body>

    <script>
   
        function purposeFun(){
            if(document.getElementById("other_purpose_opt").checked){
                document.getElementById('other_purpose').style.display='block'
                document.getElementById('for_event').style.display='none'
                document.getElementById("purp").value = "2";

            }else{
                document.getElementById('other_purpose').style.display='none'
                document.getElementById('for_event').style.display='block'
                document.getElementById("purp").value = "1";

            }
        }

        function add_input(element){
            var parent = element.parentElement.parentElement;
            if(element.parentElement.children[0].value!=='' || element.parentElement.children[1].value!=='') {
                for (var ele of parent.children) {
                    ele.children[0].setAttribute("value", ele.children[0].value);
                    ele.children[1].setAttribute("value", ele.children[1].value);
                    ele.children[2].outerHTML = "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>"
                }
                parent.innerHTML += '<div class="input_sub_container">\n' +
                    '        <input type="text" name="item[]" class="text_input" placeholder="item">\n' +
                    '        <input type="text" name="amount[]" class="text_input" placeholder="amount">\n' +
                    '        <button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>\n' +
                    '    </div>';
            }
        }
        function remove_input(element){
            element.parentElement.outerHTML='';
        }
    </script>

</html>