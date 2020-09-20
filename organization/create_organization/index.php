<?php
ob_start();
ignore_user_abort();

require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
require $_SERVER['DOCUMENT_ROOT'].'/organization/create_organization/create_org_php.php';
?>
<title>create new organization </title>
<link rel='stylesheet' href='/css_codes/create_org.css'>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script>
    btnPress(6);
</script>
<style>
    .leader-has-error{
        border: 2px solid #b93a29;
        background-color: #b93a294d;
    }
</style>

<div id='form_main_body'>

    <form method='post' action='' ng-app="" name="createOrgForm" id='createOrgForm' novalidate ng-init="orgName='<?php echo $org_name?>';orgMail='<?php echo $email ?>';orgNum=<?php echo $phone_num ?>">
        <div class="form_header_div">Create a new organization</div>
        <div id='form_sub_body'>

            <div class="name_div">
                <label class='create_org_label'>Organization name</label>
                <div>
                    <div ng-class="{'has-error': (createOrgForm.org_name.$invalid && createOrgForm.org_name.$touched)}">
                        <input class="create_org_input" id='org_name_inp' type='text' name="org_name"  ng-model="orgName" required>
                        <div></div>
                    </div>
                    <span class='error'><?php echo $nameErr ?></span>
                    <span class='error' data-ng-show="createOrgForm.org_name.$invalid && createOrgForm.org_name.$touched"><i class='fas fa-exclamation-circle'></i> Name Required</span>
                </div>
            </div>

            <div class="leader_div">
                <label class='create_org_label'>Leader</label>
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
                <div style="width:100px;">
                    <input type='radio' name="leader" id="leader" value='you' <?php echo $rad_you ?> onclick='leaderFun()'>
                    <label class="create_org_label" for="leader">You</label>
                </div>
                <div>
                    <input type='radio' name="leader" id='other_leader' value='others' <?php echo $rad_others; ?> onclick='leaderFun()'>
                    <label class="create_org_label" for="other_leader">Others</label>
                </div>
            </div>
            <div class="leader_nic_div" id='other_leader_nic'>
                <label class="create_org_label">Leader Name</label>
                <div>
                    <div>

                    </div>
                    <div class="leader_name">
                        <input type='hidden' name='leader_nic' onchange='leader_value(this)' ng-model="leaderNic">
                        <input class="create_org_input" id='leader_name_inp' type='text' placeholder='Leader name' ng-model="leaderNic" required>
                    </div>
                    <span class='error'><?php echo '' ?></span>
                    <span class='error' data-ng-show="createOrgForm.leader_nic.$invalid && createOrgForm.leader_nic.$touched"><i class='fas fa-exclamation-circle'></i> Invalid NiC Format</span>
                </div>
            </div>
            <script>
                function leaderFun(){
                    var other_leader_cont = document.getElementById('other_leader_nic');
                    if(document.getElementById("other_leader").checked){
                        other_leader_cont.style.display = 'flex';

                    }else{
                        other_leader_cont.style.display='none'
                    }
                }
            </script>

            <!--div class="co_leader_div">
                <label class="create_org_label">Co-leaders</label> 
                <div class="input_container" id='coleader_container'></div>
            </div-->

            <div class="dis_div">
                <label class="create_org_label">Service district</label>
                <div class="custom-select" style="width:200px;">
                    <select name="district">
                        <?php $dis_array = ['All Island','Ampara','Anurashapura','Badulla','Batticaloa','Colombo','Galle','Gampha','Hambatota',
                        'Jaffna','Kaltura','Kandy','Kegalle','Kilinochchi','Kurunegala','Mannar','Matale','Mathara','Moneragala',
                        'Mullaitivu','Nuwara-Eliya','Polonnaruwa','Puttalam','Ratnapura','Tricomalee','Vavuniya'];
                        foreach($dis_array as $dis){
                            echo "<option value='".$dis."' ";
                            if($dis == $district){
                                echo 'selected';
                            }
                            echo ">".$dis."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="email_div">
                <label class="create_org_label">Organization Email</label>
                <div>
                    <div ng-class="{'has-error': createOrgForm.email.$invalid}">
                        <input class="create_org_input" type='email' name="email" ng-model="orgMail">
                    </div>
                    <span class='error' data-ng-show="createOrgForm.email.$error.email && createOrgForm.email.$touched"><i class='fas fa-exclamation-circle'></i> Invalid Email</span>
                </div>
            </div>

            <div class="phone_div">
                <label class="create_org_label">Phone number</label>
                <div>
                    <div ng-class="{'has-error': (createOrgForm.phone_num.$invalid && createOrgForm.phone_num.$touched)}">
                        <input class="create_org_input" type='tel' name="phone_num" pattern="[0-9]{9}|[0-9]{10}" minlength="9" maxlength="10" ng-model="orgNum">
                    </div>
                    <span class='error' data-ng-show="createOrgForm.phone_num.$invalid && createOrgForm.phone_num.$touched"><i class='fas fa-exclamation-circle'></i> Invalid Number Format</span>
                </div>
            </div>

            <div class="discrip_div">
                <label class="create_org_label">description</label>
                <textarea class="create_org_textarea" name='description'></textarea>
            </div>

            <!--div class="mem_div">
                <label class="create_org_label"> Members</label> 
                <div class="input_container" id="member_container">
                    <div class="input_sub_container">
                        <input type="text" class="create_org_input" name='members[]'>
                        <button type="button" onclick="add(this)" class="add_rem_btn">Add</button>
                    </div>
                </div>
            </div-->
            </div>
            <div class="create_org_btn_container">
                <a href="<?php echo $_SERVER['HTTP_REFERER']?>"><button type='button' name='cancel_button' class="create_org_cancel_btn submitt">Cancel</button></a>
                <button type='button' name='submit_button' class="create_org_submit_btn" id='submitBtn'>Submit</button>
            </div>
        
            
            
        </form>
        <div id='form_loader'>
            <div class='lds-default'><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>

        <div id='coleaderForm'>
            <div class="form_header_div">Add Co-Loeaders</div>

            <form id="coleader_form">
                <div id="coleader_container">

                </div>
            </form>

            <div class="coleader_input_cont">
                <div>
                    <input type="text" placeholder="Add new co-leader" id="new_coleader_input">
                </div>
            </div>
            <div class="coleader_btn_container">
                <button type='button' class="create_org_cancel_btn submitt">Skip</button></a>
                <button type='button' class="create_org_submit_btn" onclick="submit_coleader()">Next</button>
            </div>
        </div>

        <div id='memberForm'>
            <div class="form_header_div">Add Members</div>
            <form id="member_form">
                <div id="member_container">

                </div>
            </form>
            <div class="member_input_cont">
                <div>
                    <input type="text" placeholder="Add new member" id="new_member_input">
                </div>
            </div>
            <div class="member_btn_container">
                <button type='button' class="create_org_cancel_btn submitt">Skip</button></a>
                <button type='button' class="create_org_submit_btn" onclick="submit_member()">Next</button>
            </div>
        </div>

        <div id="add_profile_cont">
            <div class="form_header_div">Add Profile</div>
            <div id='profile_image_container'>
                <img id='profile_preview' src='http://d-c-a.000webhostapp.com/Organization/Profiles/default.jpg'/>
            </div>
            <div id='upload_profile_button' class='post_btn'>Upload photo</div>
            <form id="profile_form">
                <input type='file' name='upload_file' accept='image/*' id='profile_file' style='display:none'>
            </form>
            <div class="member_btn_container">
                <button type='button' class="create_org_cancel_btn submitt">Skip</button></a>
                <button type='button' class="create_org_submit_btn" onclick="add_profile()">Next</button>
            </div>
        </div>

        <div id="add_cover_cont">
            <div class="form_header_div">Add cover</div>
            <div id='cover_image_container'>
                <img id='cover_preview' src='http://d-c-a.000webhostapp.com/Organization/Covers/default.jpg'/>
            </div>
            <div id='upload_cover_button' class='post_btn'>Upload photo</div>
            <form id="cover_form">
                <input type='file' name='upload_file' accept='image/*' id='cover_file' style='display:none'>
            </form>
            <div class="member_btn_container">
                <button type='button' class="create_org_cancel_btn submitt">Skip</button></a>
                <button type='button' class="create_org_submit_btn" onclick="add_cover()">Finish</button>
            </div>
        </div>
</div>

<script>

    var leader_inp = document.getElementById('leader_name_inp')
    autocomplete_ready(leader_inp, 'users', 'ready', leader_value);
    var org_id = null;

    function leader_value(name, nic){
        leader_inp.value = '';
        leader_inp.setAttribute('placeholder', 'change leader');
        leader_inp.previousElementSibling.value = nic;
        leader_inp.parentElement.previousElementSibling.innerHTML = '<div><div class="autocomplete_img_cont"><img class="autocomplete_img" src="http://d-c-a.000webhostapp.com/Profiles/resized/'+nic+'.jpg" onload="{this.style.visibility=&quot;visible&quot;}" style="visibility: visible;"></div> <strong>'+name+'</strong></div>';
    }

    //setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 2000;  //time in ms, 5 second for example
    var input = document.getElementById('org_name_inp');

    //on keyup, start the countdown
    input.addEventListener('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    //on keydown, clear the countdown 
    input.addEventListener('keydown', function () {
        clearTimeout(typingTimer);
    });

    //user is "finished typing," do something
    function doneTyping () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText==='1'){
                    input.classList.add('ng-invalid');
                    input.nextElementSibling.innerHTML='Name already exit.';
                }else{
                    input.classList.remove('ng-invalid');
                    input.nextElementSibling.innerHTML='Name available.';
                }
            }
            if(this.readyState == 1){
                input.nextElementSibling.innerHTML = "<div class='loader'></div>";
            }
        };
        xhttp.open('GET', '/organization/create_organization/validate_name_ajax.php?name='+input.value,true);
        xhttp.send();
    }

    document.getElementById('submitBtn').onclick = function(e){
        e.preventDefault();
        if(($('input[name$="org_name"]:first').hasClass('ng-invalid') || $('input[name$="leader"]')[1].checked && ($('input[name$="leader_nic"]:first').val()=='') || $('input[name$="email"]:first').hasClass('ng-invalid') || $('input[name$="phone_num"]:first').hasClass('ng-invalid') )){
            alert('Please Fill the form Correctly');
        }else{
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    var response = JSON.parse(this.responseText);
                    if(response.status==='invalid'){
                        document.getElementById('form_loader').style.display='none';
                    }else if(response.status==='ok'){
                        document.getElementById('form_loader').style.display='none';
                        document.getElementById('createOrgForm').style.display='none';
                        document.getElementById('coleaderForm').style.display='block';
                        org_id = response.org_id;
                    }
                }
                if(this.readyState == 1){
                    document.getElementById('form_loader').style.display='block';
                }
            };

            const requestData = 'org_name='+$('input[name$="org_name"]:first').val()+
                                '&leader='+$('input[name$="leader"]:checked').val()+
                                '&leader_nic='+$('input[name$="leader_nic"]:first').val()+
                                '&district='+$('select[name$="district"]:first').val()+
                                '&email='+$('input[name$="email"]:first').val()+
                                '&phone_num='+$('input[name$="phone_num"]:first').val()+
                                '&description='+$('.create_org_textarea:first').val()+
                                '&submit_button=1';
            xhttp.open('post', '/organization/create_organization/submit_detail_ajax.php');
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send(requestData);
        }
    }
    var coleader_inp = document.getElementById('new_coleader_input');
    autocomplete_ready(coleader_inp, 'users', null, add_new_coleader);

    var coleaders = [];
    function add_new_coleader(name, nic){
        coleaders.push(nic);
        var cont=document.getElementById('coleader_container');
        cont.innerHTML+='<div>'+
                            '<div class="autocomplete_img_cont">'+
                                '<img class="autocomplete_img" src="http://d-c-a.000webhostapp.com/Profiles/resized/'+nic+'.jpg" onload="{this.style.visibility=&quot;visible&quot;}" style="visibility: visible;">'+
                            '</div>'+
                            '<strong>'+name+'</strong>'+
                            '<input type="hidden" name="coleaders[]" value="'+nic+'">'+
                            '<div class="remove_marker" onclick="remove_coleader(this)">'+
                                'X'+
                            '</div>'+
                        '</div>';
        coleader_inp.value='';
    }

    function remove_coleader(ele){
        var id = coleaders.indexOf(ele.previousElementSibling.value);
        if(id>-1){
            coleaders.splice(id, 1);
        }
        ele.parentElement.remove();
    }

    function submit_coleader(){
        var formData = new FormData(document.getElementById('coleader_form'));
        formData.append('add_coleaders', '1');
        formData.append('org_id', org_id);
        $.ajax({
            url: '/organization/create_organization/submit_detail_ajax.php',
            data: formData,
            type: 'POST',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            beforeSend: function(xhr){
                document.getElementById('form_loader').style.display='block';
            },
            success: function(data, status){
                if(status==='success'){
                    var response = JSON.parse(data);
                    if(response.status==='invalid'){
                        document.getElementById('form_loader').style.display='none';
                    }else if(response.status==='ok'){
                        document.getElementById('form_loader').style.display='none';
                        document.getElementById('coleaderForm').style.display='none';
                        document.getElementById('memberForm').style.display='block';
                    }
                }
            }
        });
    }

    var member_inp = document.getElementById('new_member_input');
    autocomplete_ready(member_inp, 'users', null, add_new_member);

    var members = [];
    function add_new_member(name, nic){
        members.push(nic);
        var cont=document.getElementById('member_container');
        cont.innerHTML+='<div>'+
                            '<div class="autocomplete_img_cont">'+
                                '<img class="autocomplete_img" src="http://d-c-a.000webhostapp.com/Profiles/resized/'+nic+'.jpg" onload="{this.style.visibility=&quot;visible&quot;}" style="visibility: visible;">'+
                            '</div>'+
                            '<strong>'+name+'</strong>'+
                            '<input type="hidden" name="members[]" value="'+nic+'">'+
                            '<div class="remove_marker" onclick="remove_member(this)">'+
                                'X'+
                            '</div>'+
                        '</div>';
        member_inp.value='';
    }

    function remove_member(ele){
        var id = members.indexOf(ele.previousElementSibling.value);
        if(id>-1){
            members.splice(id, 1);
        }
        ele.parentElement.remove();
    }

    function submit_member(){
        var formData = new FormData(document.getElementById('member_form'));
        formData.append('add_members', '1');
        formData.append('org_id', org_id);
        $.ajax({
            url: '/organization/create_organization/submit_detail_ajax.php',
            data: formData,
            type: 'POST',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            beforeSend: function(xhr){
                document.getElementById('form_loader').style.display='block';
            },
            success: function(data, status){
                if(status==='success'){
                    var response = JSON.parse(data);
                    if(response.status==='invalid'){
                        document.getElementById('form_loader').style.display='none';
                    }else if(response.status==='ok'){
                        document.getElementById('form_loader').style.display='none';
                        document.getElementById('memberForm').style.display='none';
                        document.getElementById('add_profile_cont').style.display='block';
                    }
                }
            }
        });
    }

    /*              upload profile            */

    document.getElementById('upload_profile_button').onclick = function(){document.getElementById('profile_file').click();};
    document.getElementById('profile_file').onchange=function(event){
        var output = document.getElementById('profile_preview');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };

    function add_profile(){
        var formData = new FormData(document.getElementById('profile_form'));
        formData.append('add_profile', '1');
        formData.append('org_id', org_id);
        $.ajax({
            url: '/organization/create_organization/submit_detail_ajax.php',
            data: formData,
            type: 'POST',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            beforeSend: function(xhr){
                document.getElementById('form_loader').style.display='block';
            },
            success: function(data, status){
                if(status==='success'){
                    var response = JSON.parse(data);
                    if(response.status==='invalid'){
                        document.getElementById('form_loader').style.display='none';
                    }else if(response.status==='ok'){
                        document.getElementById('form_loader').style.display='none';
                        document.getElementById('add_profile_cont').style.display='none';
                        document.getElementById('add_cover_cont').style.display='block';
                    }
                }
            }
        });
    }

    /*              /upload profile           */

    /*              upload cover              */

    document.getElementById('upload_cover_button').onclick = function(){document.getElementById('cover_file').click();};
    document.getElementById('cover_file').onchange=function(event){
        var output = document.getElementById('cover_preview');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };

    function add_cover(){
        var formData = new FormData(document.getElementById('cover_form'));
        formData.append('add_cover', '1');
        formData.append('org_id', org_id);
        $.ajax({
            url: '/organization/create_organization/submit_detail_ajax.php',
            data: formData,
            type: 'POST',
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            beforeSend: function(xhr){
                document.getElementById('form_loader').style.display='block';
            },
            success: function(data, status){
                if(status==='success'){
                    var response = JSON.parse(data);
                    if(response.status==='invalid'){
                        document.getElementById('form_loader').style.display='none';
                    }else if(response.status==='ok'){
                        document.getElementById('form_loader').style.display='none';
                        document.getElementById('add_cover_cont').style.display='none';
                        document.getElementById('add_cover_cont').style.display='block';
                    }
                }
            }
        });
    }

    /*              /upload cover             */

        //         Custom select           //

        var x, i, j, l, ll, selElmnt, a, b, c;
    /*look for any elements with the class "custom-select":*/
    x = document.getElementsByClassName("custom-select");
    l = x.length;
    for (i = 0; i < l; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    ll = selElmnt.length;
    /*for each element, create a new DIV that will act as the selected item:*/
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
    /*for each element, create a new DIV that will contain the option list:*/
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 1; j < ll; j++) {
        /*for each option in the original select element,
        create a new DIV that will act as an option item:*/
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function(e) {
            /*when an item is clicked, update the original select box,
            and the selected item:*/
            var y, i, k, s, h, sl, yl;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            sl = s.length;
            h = this.parentNode.previousSibling;
            for (i = 0; i < sl; i++) {
            if (s.options[i].innerHTML == this.innerHTML) {
                s.selectedIndex = i;
                h.innerHTML = this.innerHTML;
                y = this.parentNode.getElementsByClassName("same-as-selected");
                yl = y.length;
                for (k = 0; k < yl; k++) {
                y[k].removeAttribute("class");
                }
                this.setAttribute("class", "same-as-selected");
                break;
            }
            }
            h.click();
        });
        b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function(e) {
        /*when the select box is clicked, close any other select boxes,
        and open/close the current select box:*/
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
        });
    }
    function closeAllSelect(elmnt) {
    /*a function that will close all select boxes in the document,
    except the current select box:*/
    var x, y, i, xl, yl, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    xl = x.length;
    yl = y.length;
    for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
        arrNo.push(i)
        } else {
        y[i].classList.remove("select-arrow-active");
        }
    }
    for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i)) {
        x[i].classList.add("select-hide");
        }
    }
    }
    /*if the user clicks anywhere outside the select box,
    then close all select boxes:*/
    document.addEventListener("click", closeAllSelect);

    // $('form').attr("ng-app","");
    // $('form').attr("name","myForm");
    // $('form input[type="email"]').attr("ng-model","text");
    
</script>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>
<?php ob_end_flush();