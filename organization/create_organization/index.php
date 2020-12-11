<?php
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>create new organization </title>
        <link rel='stylesheet' href='/css_codes/create_org.css'>
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
                            <input type='radio' name="leader" value='you' <?php if(isset($leader) && $leader==$_SESSION['user_nic']) echo "checked='checked'"; ?> onclick='leaderFun()'>You</br>
                            <div style="display:flex; height:20px;">
                                <input type='radio' name="leader" id='other_leader' value='others' <?php if(isset($leader) && $leader!=$_SESSION['user_nic']) echo 'checked'; ?> onclick='leaderFun()'>Others
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
                        <td><label>Co-leaders</label> </td>
                        <td>
                                <div id=add_coleaders>
                                    <input type=text name=jsinput id=new_member>
                                    <button type=button onclick=add_coleader(this)>add</button>
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
                            <input type='submit' name='submit_button' id='submitBtn' disabled>
                        </td>
                    </tr>
                </table>
                <input type='hidden' id='hidden' name='hidden'>
                <input type='hidden' id='hidden_coleaders' name='hidden_coleaders'>
            </form>
        </div>
        <script>
            var str_coleader = "<?php echo $str_coleaders ?>";
            var str_member = "<?php echo $str_members ?>";
            console.log(str_coleader);
            console.log(str_member);

            var coleaders = str_coleader.split(" ").filter(function(el){
                return el!='';
            });
            
            var str="";
            coleaders.forEach(function(item,index){   
                str+="<input type='text' name='added_coleader' id='added"+index+"coleader' value='"+item+"'> <button type=button onclick=remove_coleader("+index+")>remove</button></br>";
            });
            str+="<input type=text name=jsinput id=new_coleader> <button type=button onclick=add_coleader(this)>add</button>";
            document.getElementById('add_coleaders').innerHTML = str;
            document.getElementById('hidden_coleaders').value=coleaders.join(" ");

            
            var members = str_member.split(" ").filter(function(el){
                return el!='';
            });
            str = "";
            members.forEach(function(item,index){   
                str+="<input type=text name=added_member id=added"+index+" value="+item+"> <button type=button onclick=remove("+index+")>remove</button></br>";
            });
            str+="<input type=text name=jsinput id=new_member> <button type=button onclick=add()>add</button>";
            document.getElementById('add_members').innerHTML = str;
            document.getElementById('hidden').value=members.join(" ");
            
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
            function add_coleader(element){
                var str='';
                var newMember = element.previousElementSibling.value;
                
                coleaders.push(newMember);

                coleaders.forEach(function(item,index){
                    
                    str+="<input type='text' name='added_coleader' id='added"+index+"coleader' value='"+item+"'> <button type=button onclick=remove_coleader("+index+")>remove</button></br>";
                });
                str+="<input type=text name=jsinput id=new_coleader> <button type=button onclick=add_coleader(this)>add</button>";
                document.getElementById('add_coleaders').innerHTML = str;
                document.getElementById('hidden_coleaders').value=coleaders.join(" ");

            }
            
        </script>
    </body>
</html>