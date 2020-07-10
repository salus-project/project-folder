<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>create new organization </title>
        <link rel='stylesheet' href='/css_codes/create_org.css'>
        <style>
            .input_container{
                font-size: 0;
            }
            .input_sub_container{
                font-size: 0;
            }
            .text_input{
                width: auto;
                height: auto;
            }
            .add_rem_btn{
                width:100px;
            }
        </style>
    </head>
    <body>
        <?php
            require 'create_org_php.php';
        ?>
        <script>
            btnPress(6);
        </script>

        <div id='form_main_body'>
            <center><h2>Create a new organization</h2></center>
            <small style="margin:10px;">Enter the details</small>
            <form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
                <table id='form_sub_body'>
                    <tr>
                        <td colspan='2'>
                            <span class='error'>* required field</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='org_name'>Organization name</label>
                        </td>
                        <td>
                            <input type='text' name="org_name" value='<?php echo $org_name; ?>'>
                            <span class='error'>* <?php echo $nameErr ?> </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='leader'>Leader</label>
                        </td>
                        <td>
                            <?php
                                if(!isset($leader) || $leader=='' || $leader==$_SESSION['user_nic']){
                                    $rad_you='checked';
                                    $rad_others='';
                                    $others_input="'display:none'";
                                    $others_value='';
                                }else{
                                    $rad_you='';
                                    $rad_others='checked';
                                    $others_input='';
                                    $others_value=$leader;
                                }
                            ?>
                            <input type='radio' name="leader" value='you' <?php echo $rad_you ?> onclick='leaderFun()'>You</br>
                            <div style="display:flex; height:20px;">
                                <input type='radio' name="leader" id='other_leader' value='others' <?php echo $rad_others; ?> onclick='leaderFun()'>Others
                                <input type='text' name='leader_nic' id='other_leader_nic' placeholder='Leader NIC num' value='<?php echo $others_value ?>' style=<?php echo $others_input ?>>
                            </div>
                            
                            <script>
                                function leaderFun(){
                                    if(document.getElementById("other_leader").checked){
                                        document.getElementById('other_leader_nic').style.display='block'
                                        
                                    }else{
                                        document.getElementById('other_leader_nic').style.display='none'
                                    }
                                }
                            </script>
                            
                        </td>
                    </tr>
                    <tr>
                        <td><label>Co-leaders</label> </td>
                        <td>
                            <div class="input_container" id='coleader_container'>
                                
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='district'>Service district</label>
                        </td>
                        <td>
                            <select name="district">
                                <option value='all island'>All island</option>
                                <option value='Ampara'>Ampara</option>
                                <option value='Anurashapura'>Anurashapura</option>
                                <option value='Badulla'>Badulla</option>
                                <option value='Batticaloa'>Batticaloa</option>
                                <option value='Colombo'>Colombo</option>
                                <option value='Galle'>Galle</option>
                                <option value='Gampha'>Gampha</option>
                                <option value='Hambatota'>Hambantota</option>
                                <option value='Jaffna'>Jaffna</option>
                                <option value='Kaltura'>Kaltura</option>
                                <option value='Kandy'>Kandy</option>
                                <option value='Kegalle'>Kegalle</option>
                                <option value='Kilinochchi'>Kilinochchi</option>
                                <option value='Kurunegala'>Kurunegala</option>
                                <option value='Mannar'>Mannar</option>
                                <option value='Matale'>Matale</option>
                                <option value='Mathara'>Mathara</option>
                                <option value='Moneragala'>Moneragala</option>
                                <option value='Mullaitivu'></option>
                                <option value='Nuwara-Eliya'>Nuwara-Eliya</option>
                                <option value='Polonnaruwa'>Polonnaruwa</option>
                                <option value='Puttalam'>Puttalam</option>
                                <option value='Ratnapura'>Ratnapura</option>
                                <option value='Tricomalee'>Tricomalee</option>
                                <option value='Vavuniya'>Vavuniya</option>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Organization Email</label>
                        </td>
                        <td>
                            <input type='email' name="email" value=<?php echo $email; ?>>
                            <span class='error'><?php echo $emailErr ?> </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='phone_num'>Phone number</label>
                        </td>
                        <td>
                            <input type='tel' name="phone_num" value=<?php echo $phone_num; ?>>
                            <span class='error'><?php echo $phoneErr ?> </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Discription</label>
                        </td>
                        <td>
                            <textarea name='discription'><?php echo $discription; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td><label> Members</label> </td>
                        <td>
                            <div class="input_container" id="member_container">
                                <div class="input_sub_container">
                                    <input type="text" class="text_input" name='members[]'>
                                    <button type="button" onclick="add(this)" class="add_rem_btn">Add</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <input type='checkbox' name='valiate' onclick='myfunction()' id="checkbox">
                            <label for='validate'>I have read the terms and conditions</label>
                            
                            <script>
                            
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <input type='submit' name='submit_button' id='submitBtn' disabled>
                        </td>
                    </tr>
                </table>
                <input type='hidden' id='hidden' name='hidden'>
                <input type='hidden' id='hidden_coleaders' name='hidden_coleaders'>
            </form>
        </div>
        <script>

            var coleaders= <?php echo json_encode($coleaders); ?>;
            var members= <?php echo json_encode($members); ?>;

            var str='';
            for(var coleader of coleaders){
                str+=   '<div class="input_sub_container">\n'+
                            '<input type="text" class="text_input" name="coleaders[]" value="'+coleader+'">\n'+
                            '<button type="button" onclick="remove(this)" class="add_rem_btn">Remove</button>\n'+
                        '</div>';
            }
            str+=       '<div class="input_sub_container">\n'+
                            '<input type="text" class="text_input" name="coleaders[]">\n'+
                            '<button type="button" onclick="add_coleader(this)" class="add_rem_btn">Add</button>\n'+
                        '</div>';
            document.getElementById('coleader_container').innerHTML=str;

            var str='';
            for(var member of members){
                str+=   '<div class="input_sub_container">\n'+
                            '<input type="text" class="text_input" name="members[]" value="'+member+'">\n'+
                            '<button type="button" onclick="remove(this)" class="add_rem_btn">Remove</button>\n'+
                        '</div>';
            }
            str+=       '<div class="input_sub_container">\n'+
                            '<input type="text" class="text_input" name="members[]">\n'+
                            '<button type="button" onclick="add(this)" class="add_rem_btn">Add</button>\n'+
                        '</div>';
            document.getElementById('member_container').innerHTML=str;
            
            function myfunction(){
                //var x = ;
                if(document.getElementById('checkbox').checked){
                    document.getElementById("submitBtn").disabled=false;
                }
                else{
                    document.getElementById("submitBtn").disabled=true;
                }
            }
            
            function add(element){
                var parent = element.parentElement.parentElement;
                if(element.parentElement.children[0].value!=='') {
                    for (var ele of parent.children) {
                        ele.children[0].setAttribute("value", ele.children[0].value);
                        ele.children[1].outerHTML = "<button type='button' onclick='remove(this)' class='add_rem_btn'>Remove</button>"
                    }
                    parent.innerHTML += '<div class="input_sub_container">\n' +
                        '        <input type="text" class="text_input" name="members[]">\n' +
                        '        <button type="button" onclick="add(this)" class="add_rem_btn">Add</button>\n' +
                        '    </div>';
                }

            }
            function remove(element){
                element.parentElement.outerHTML='';
            }

            function add_coleader(element){
                var parent = element.parentElement.parentElement;
                if(element.parentElement.children[0].value!=='') {
                    for (var ele of parent.children) {
                        ele.children[0].setAttribute("value", ele.children[0].value);
                        ele.children[1].outerHTML = "<button type='button' onclick='remove(this)' class='add_rem_btn'>Remove</button>"
                    }
                    parent.innerHTML += '<div class="input_sub_container">\n' +
                        '        <input type="text" class="text_input" name="coleaders[]">\n' +
                        '        <button type="button" onclick="add_coleader(this)" class="add_rem_btn">Add</button>\n' +
                        '    </div>';
                }
            }
            
        </script>
    </body>
</html>