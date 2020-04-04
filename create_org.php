<?php  
    session_start();
    require 'dbconfi/confi.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>create new organization </title>
        <link rel='stylesheet' href='css_codes/create_org.css'>
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <?php
            require 'create_org_php.php';
            require 'header.php';
        ?>
        <script>
            btnPress(6);
        </script>

        <div id='main_body'>
            <center><h2>Create a new organization</h2></center>
            <small style="margin:10px;">Enter the details</small>
            <form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
                <table id='sub_body'>
                    <tr>
                        <td colspan='2'>
                            <span id='error'>* required field</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='org_name'>Organization name</label>
                        </td>
                        <td>
                            <input type='text' name="org_name" value=<?php echo $org_name; ?>>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='leader'>Leader</label>
                        </td>
                        <td>
                            <input type='radio' name="leader" value='you' <?php if(isset($leader) && $leader=='you') echo 'checked'; ?> onclick='leaderFun()'>You</br>
                            <div style="display:flex; height:20px;">
                                <input type='radio' name="leader" id='other_leader' value='others' <?php if(isset($leader) && $leader=='others') echo 'checked'; ?> onclick='leaderFun()'>Others
                                <input type='text' name='leader_nic' id='other_leader_nic' placeholder='Leader NIC num' style='display:none'>
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
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='phone_num'>Phone number</label>
                        </td>
                        <td>
                            <input type='tel' name="phone_num" value=<?php echo $phone_num; ?>>
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
                                <div id=add_members>
                                    <input type=text name=jsinput id=new_member>
                                    <button type=button onclick=add()>add</button>
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
                            <input type='submit' name='submit_button' id='submitBtn' disabled onclick=setCookie()>
                        </td>
                    </tr>
                </table>
                <input type=hidden id=hidden name=hidden>
            </form>
        </div>
        <script>
            var members = [];
            
            function myfunction(){
                //var x = ;
                if(document.getElementById('checkbox').checked){
                    document.getElementById("submitBtn").disabled=false;
                }
                else{
                    document.getElementById("submitBtn").disabled=true;
                }
            }
            
            function add(){
                var str='';
                var newMember = document.getElementById('new_member').value;
                
                members.push(newMember);

                members.forEach(function(item,index){
                    
                    str+="<input type=text name=added_member id=added"+index+" value="+item+"> <button type=button onclick=remove("+index+")>remove</button></br>";
                });
                str+="<input type=text name=jsinput id=new_member> <button type=button onclick=add()>add</button>";
                document.getElementById('add_members').innerHTML = str;
                document.getElementById('hidden').value=members.join(" ");

            }
            function remove(rem_index){
                delete members[rem_index];
                
                members = members.filter(function(element){
                    return element !== undefined;
                });
                str='';
                members.forEach(function(item,index){
                    
                    str+="<input type=text name=added_member id=added"+index+" value="+item+"> <button type=button onclick=remove("+index+")>remove</button></br>";
                });
                str+="<input type=text name=jsinput id=new_member> <button type=button onclick=add()>add2</button>";
                document.getElementById('add_members').innerHTML = str;
                document.getElementById('hidden').value=members.join(" ");
            }
            
        </script>
    </body>
</html>