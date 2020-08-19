<?php
    require $_SERVER['DOCUMENT_ROOT']."/staff/header.php";

    $first_name = $last_name = $gender = $nic = $password = $address = $district=$village=$street = $occupation = $phone_number = $email_address = "";
    $first_name_err = $last_name_err = $gender_err = $nic_err = $password_err = $address_err = $district_err = $village_err =$street_err= $occupation_err = $phone_number_err = $email_address_err = ""; 
    require $_SERVER['DOCUMENT_ROOT']."/staff/create_civilian_acc_php.php";
?> 

<html> 
<head>
    <link rel="stylesheet" href="/staff/css_codes/create_civilian_acc.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
</head>
<body>
    <form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' ng-app="" name="CreateCivilianAccForm" id='CreateCivilianAccForm' novalidate ng-init="Nic='<?php echo $nic?>';firstName='<?php echo $first_name?>';lastName='<?php echo $last_name?>';userPhone='<?php echo $phone_number?>';userMail='<?php echo $email_address?>';">
        <div class="create_civ_form_box">

            <div class="head_create_civ_form"> 
                <div class="head_create_civ_form_det">Create new member</div>
            </div>

            <div class="body_create_civ_form">

            <div class="create_civ_grp">
                <label class="create_civ_form_label">NIC number</label>
                <div>
                    <div ng-class="{'has-error': CreateCivilianAccForm.nic.$invalid}">
                        <input class="create_civ_input_box" type='text' name='nic' placeholder='Enter NIC number' value='' pattern="[0-9]{9}V|[0-9]{9}v|[0-9]{11}" ng-model="Nic" required>
                    </div>
                    <span class='error' data-ng-show="CreateCivilianAccForm.nic.$invalid && CreateCivilianAccForm.nic.$touched"><i class='fas fa-exclamation-circle'></i> Invalid NIC Format</span>
                </div>
            </div>

            <div class="create_civ_grp">
                <label class="create_civ_form_label">Password </label>
                <div>
                    <div ng-class="{'has-error': (CreateCivilianAccForm.password.$invalid && CreateCivilianAccForm.password.$touched)}">
                        <input name="password" type="password" class="create_civ_input_box" placeholder='Enter password' ng-model="password" required/>
                    </div>
                    <span class="error"> <?php echo $password_err; ?></span>
                    <span class='error' data-ng-show="CreateCivilianAccForm.password.$invalid && CreateCivilianAccForm.password.$touched"><i class='fas fa-exclamation-circle'></i> Please fill password</span>
                </div>
            </div>

            <div class="create_civ_grp">
                <label class="create_civ_form_label">First Name </label>
                <div>
                    <div ng-class="{'has-error': (CreateCivilianAccForm.first_name.$invalid && CreateCivilianAccForm.first_name.$touched)}">
                        <input name = "first_name" type="text" class="create_civ_input_box" placeholder="Enter first name" ng-model="firstName" required>
                    </div>
                    <span class='error' data-ng-show="CreateCivilianAccForm.first_name.$invalid && CreateCivilianAccForm.first_name.$touched"><i class='fas fa-exclamation-circle'></i> First name Required</span>
                </div>
            </div>

            <div class="create_civ_grp">
                <label class="create_civ_form_label">Last Name </label>
                <div>
                    <div ng-class="{'has-error': (CreateCivilianAccForm.last_name.$invalid && CreateCivilianAccForm.last_name.$touched)}">
                        <input name = "last_name" type="text" class="create_civ_input_box" placeholder="Enter last name" ng-model="lastName" required>
                    </div>
                    <span class='error' data-ng-show="CreateCivilianAccForm.last_name.$invalid && CreateCivilianAccForm.last_name.$touched"><i class='fas fa-exclamation-circle'></i> Last name Required</span>
                </div>
            </div>

            
            <div class="create_civ_grp">
                <label class="create_civ_form_label"> Gender </label>
                <div class="custom-select" style="width:200px;">
                    <select name="gender" class="edit_prof_select">
                        <option value=''>select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div> 
            </div>

            <div class="create_civ_grp">
                <label class="create_civ_form_label">Address </label>
                <textarea name = "address" type="text" class="create_civ_textarea" placeholder="Enter address" value="<?php echo $address; ?>"required/></textarea>
            </div>


            <div class="create_civ_grp">
                <label class="create_civ_form_label"> District </label>
                <div class="custom-select" style="width:200px;">
                    <select name="district" class="edit_prof_select">
                        <option value=''>select district</option>
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
                        <option value='Mullaitivu'>Mullaitivu</option>
                        <option value='Nuwara-Eliya'>Nuwara-Eliya</option>
                        <option value='Polonnaruwa'>Polonnaruwa</option>
                        <option value='Puttalam'>Puttalam</option>
                        <option value='Ratnapura'>Ratnapura</option>
                        <option value='Tricomalee'>Tricomalee</option>
                        <option value='Vavuniya'>Vavuniya</option>
                    </select>
                </div>
            </div>
            
            <div class="create_civ_grp">
                <label class="create_civ_form_label">Village </label>
                <input name = "village" type="text" class="create_civ_input_box" placeholder="Enter village" value="<?php echo $village; ?>"required/>
            </div>

            <div class="create_civ_grp">
                <label class="create_civ_form_label">Street </label>
                <input name = "street" type="text" class="create_civ_input_box" placeholder="Enter street" value="<?php echo $street; ?>"required/>
            </div>

            <div class="create_civ_grp">
                <label class="create_civ_form_label">Occupation </label>
                <input name = "occupation" type="text" class="create_civ_input_box" placeholder="Enter occupation"  value="<?php echo $occupation; ?>"required/><br>
            </div>

            <div class="create_civ_grp">
                <label class="create_civ_form_label">Email </label>
                <div>
                    <div ng-class="{'has-error': CreateCivilianAccForm.email_address.$invalid}">
                        <input name = "email_address" type="email" class="create_civ_input_box" placeholder="Enter email address" ng-model="userMail" required>
                    </div>
                    <span class='error' data-ng-show="CreateCivilianAccForm.email_address.$error.email && CreateCivilianAccForm.email_address.$touched"><i class='fas fa-exclamation-circle'></i> Invalid Email</span>
                </div>
            </div>

            <div class="create_civ_grp">
                <label class="create_civ_form_label">Phone Number </label>
                <div>
                    <div ng-class="{'has-error': (CreateCivilianAccForm.phone_number.$invalid && CreateCivilianAccForm.phone_number.$touched)}">
                        <input name = "phone_number" type="tel" class="create_civ_input_box" placeholder="Enter phone number" pattern="[0-9]{9}|[0-9]{10}" ng-model="userPhone" required/>
                    </div>
                    <span class='error' data-ng-show="CreateCivilianAccForm.phone_number.$invalid && CreateCivilianAccForm.phone_number.$touched"><i class='fas fa-exclamation-circle'></i> Invalid Number Format</span>
                </div>
            </div>
            </div>
            <div class="foot_create_civ_form">
                <button name="submit" type="submit"  value="Update"  class="create_civ_submit_button submitt">Submit</button>
                <a href="<?php echo $_SERVER['HTTP_REFERER']?>"><button name="cancel_button" type="button"  value="Cancel"  class="create_civ_submit_button">Cancel</button></a>
            </div>
            
        </div> 
    </form>
   
</body>
</html>

<script>

    var module = angular.module("CreateCivilianAccForm", []);

    module.controller("formCtrl", ['$scope', function($scope){

        $scope.data = {};

    }]);

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