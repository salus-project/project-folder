<?php  
    require $_SERVER['DOCUMENT_ROOT']."/anonymous/ano_header.php";
    //require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
?>

<link rel="stylesheet" href="/css_codes/forgot_password.css">
<div class='outer'>
<div class="forgot_password_container">
    
    <div class="app_name">Disaster and Crisis Assistent </div>
    <div class="heading_1">Recover your account</div>
    
    <div class="forgot_body" id="forgot_body">
    <label><b>Enter your NIC</b></label>
        <input type="text" class="nic_input" placeholder="Enter NIC" onkeypress='enterKey(event)' required> 
        <br><button type="button" onclick="next()" class="next_btn">Next</button> 
    </div>
</div>
</div>
<script>
    var nic=null;
    const loader = "<div class='lds-default'><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>";

    function enterKey(e){
        if(e.keyCode==13){
            next();
        }
    }

    function next(){
        nic= document.getElementsByClassName('nic_input')[0].value ;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText=="mail sent"){
                    change(nic);
                }
                else{
                    document.getElementsByClassName('forgot_body')[0].innerHTML='<div class="heading_2">Invalid NIC number</div>'+
                                                                '<input type="text" class="nic_input" placeholder="Enter NIC" onkeypress="enterKey(event)" required>'+
                                                                '<br><button type="button" onclick="next()" class="next_btn">Next</button> ';
                    console.log(this.responseText);
                }
            }else if(this.readyState == 1) {
                document.getElementsByClassName('forgot_body')[0].innerHTML=loader;
            }
        };
        xhttp.open("POST", "/anonymous/forgot_password/post_ajax.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("nic="+nic);
    }

    function change(nic){
        document.getElementsByClassName('forgot_body')[0].innerHTML='<div class="user_nic"><i class="fa fa-user" aria-hidden="true"></i>User name<br><input class="user_password_label" value="'+nic+'" disabled></div>'
                                    +'<i class="fa fa-lock" aria-hidden="true"></i><b>New password</b><br> <input type="password" class="user_password" placeholder="Enter Password" name="password" required>'
                                    +'<button type="button" onclick="login()" class="login_btn" >Log in</button> ';

    }
    function login(){
        var password=document.getElementsByClassName('user_password')[0].value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText=="true"){
                    document.getElementsByClassName('forgot_body')[0].innerHTML=' <form class="submit_form" action="/anonymous/forgot_password/login_submit.php" method="post">'
                                    +'<input type="hidden" name="nic" value="'+nic+'">'
                                    +'<i class="fa fa-lock" aria-hidden="true"></i><b>Change password</b><br><input type="password" class="new_password" placeholder="Enter new Password" name="password" required>'
                                    +'<button type="submit"  class="submit_btn" >Save</button> </form>';

                }
                else{
                    document.getElementsByClassName('forgot_body')[0].innerHTML='<div class="user_nic"><i class="fa fa-user" aria-hidden="true"></i>User name<br><input class="user_password_label" value="'+nic+'" disabled></div>'
                                    +'<input type="hidden" class="nic_input" value="'+nic+'">'
                                    +'<input type="password" class="user_password" placeholder="Enter Password" name="password" required>'
                                    +'<span class="error_msg" >Invalid password </span>'
                                    +'<button type="button" onclick="login()" class="login_btn" >Log in</button> '
                                    +'<button type="button" onclick="next()" class="retry_btn" >Send again</button> ';

                    console.log(this.responseText);
                }
            }else if(this.readyState == 1) {
                document.getElementsByClassName('forgot_body')[0].innerHTML=loader;
            }
        };
        xhttp.open("POST", "/anonymous/forgot_password/login_ajax.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("nic="+nic+"&password="+password);
    }
    
    //window.location.href="/govpost";
</script>
