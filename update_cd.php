<?php
    ob_start();
    require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
    require $_SERVER['DOCUMENT_ROOT'].'/edit_profile.php';

    $nic=$_SESSION['user_nic'];
    $first_name=$_SESSION['first_name'];
    $last_name=$_SESSION['last_name'];

    $query="select * from civilian_detail where NIC_num='".$nic."';";
    $data= mysqli_query($con,$query);
    if($data->num_rows>0){
        while($row=$data->fetch_assoc()){
            $gender=$row['gender'];
            $district=$row['district'];
            $occupation=$row['Occupation'];
            $address=$row['address'];
            $email=$row['email'];
            $phone_num=$row['phone_num'];
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Update</title>
        <link rel="stylesheet" href="/css_codes/edit_profile.css">
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

    </head>

    <body>
 
    <script> btnPress(1) </script>
    <form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' ng-app="" name="userDetailEditForm" id='userDetailEditForm' novalidate ng-init="firstName='<?php echo $first_name?>';lastName='<?php echo $last_name?>';userMail='<?php echo $email?>';userPhone='<?php echo $phone_num?>';">
            <div class="edit_prof_form_box">

                <div class="head_edit_prof_form"> 
                    <div class="head_edit_prof_form_det"><?php echo $first_name." ".$last_name;  ?></div>
                </div>

                <div class="body_edit_prof_form">
                
                    <div class="edit_prof_grp">
                        <label class="edit_form_label">First Name </label>
                        <div>
                            <div ng-class="{'has-error': (userDetailEditForm.first_name.$invalid && userDetailEditForm.first_name.$touched)}">
                                <input name = "first_name" type="text" class="edit_prof_input_box" ng-model="firstName" required>
                            </div>
                            <span class='error' data-ng-show="userDetailEditForm.first_name.$invalid && userDetailEditForm.first_name.$touched"><i class='fas fa-exclamation-circle'></i> First name Required</span>
                        </div>
                    </div>

                    <div class="edit_prof_grp">
                        <label class="edit_form_label">Last Name </label>
                        <div>
                            <div ng-class="{'has-error': (userDetailEditForm.last_name.$invalid && userDetailEditForm.last_name.$touched)}"> 
                                <input name = "last_name" type="text" class="edit_prof_input_box" ng-model="lastName" required>
                            </div>
                            <span class='error' data-ng-show="userDetailEditForm.last_name.$invalid && userDetailEditForm.last_name.$touched"><i class='fas fa-exclamation-circle'></i> Last name Required</span>
                        </div>
                    </div>

                    <div class="edit_prof_grp">
                        <label class="edit_form_label"> Gender </label>
                        <div class="custom-select" style="width:200px;">
                            <select name="gender" class="edit_prof_select">
                                <?php 
                                    $gender_array = ['Gender', 'Male','Female','Other'];
                                    foreach($gender_array as $gen){
                                        echo "<option value='".$gen."' ";
                                        if($gen == $gender){
                                            echo 'selected';
                                        }
                                        echo ">".$gen."</option>";
                                    }
                                ?>
                            </select>
                        </div> 
                    </div>

                    <div class="edit_prof_grp">
                        <label class="edit_form_label">District </label>
                        <div class="custom-select" style="width:200px;">
                    <select name="district">
                        <?php $dis_array = ['Select District','Ampara','Anurashapura','Badulla','Batticaloa','Colombo','Galle','Gampha','Hambatota',
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
                </div></div>

                    <div class="edit_prof_grp">
                        <label class="edit_form_label">Occupation </label>
                        <input name = "occupation" type="text" class="edit_prof_input_box" value="<?php echo $occupation; ?>"required/><br>
                    </div>

                    <div class="edit_prof_grp">
                        <label class="edit_form_label">Address </label>
                        <input name = "address" type="text" class="edit_prof_input_box" value="<?php echo $address; ?>"required/><br>
                    </div>

                    <div class="edit_prof_grp">
                        <label class="edit_form_label">Email </label>
                        <div>
                            <div ng-class="{'has-error': userDetailEditForm.email.$invalid}">
                                <input name = "email" type="email" class="edit_prof_input_box" ng-model="userMail" required>
                            </div>
                            <span class='error' data-ng-show="userDetailEditForm.email.$error.email && userDetailEditForm.email.$touched"><i class='fas fa-exclamation-circle'></i> Invalid Email</span>
                        </div>
                    </div>

                    <div class="edit_prof_grp">
                        <label class="edit_form_label">Phone Number </label>
                        <div>
                            <div ng-class="{'has-error': (userDetailEditForm.phone_num.$invalid && userDetailEditForm.phone_num.$touched)}">
                                <input name = "phone_num" type="tel" class="edit_prof_input_box" pattern="[0-9]{9}|[0-9]{10}" ng-model="userPhone" required/>
                            </div>
                            <span class='error' data-ng-show="userDetailEditForm.phone_num.$invalid && userDetailEditForm.phone_num.$touched"><i class='fas fa-exclamation-circle'></i> Invalid Number Format</span>
                        </div>
                    </div>

                    <div class="edit_prof_grp">
                        <label class="edit_form_label">Current Password </label>
                        <div>
                            <div ng-class="{'has-error': (userDetailEditForm.current_password.$invalid && userDetailEditForm.current_password.$touched)}">
                                <input name="current_password" type="password" class="edit_prof_input_box" ng-model="currentPassword" required/>
                            </div>
                            <span class='error'><?php echo $pswErr ?></span>
                            <span class='error' data-ng-show="userDetailEditForm.current_password.$invalid && userDetailEditForm.current_password.$touched"><i class='fas fa-exclamation-circle'></i> Please fill password</span>
                        </div>
                    </div>

                    <div class="edit_prof_grp">
                        <label class="edit_form_label">New Password </label>
                        <div>
                            <div ng-class="{'has-error': (userDetailEditForm.new_password.$invalid && userDetailEditForm.new_password.$touched)}">
                                <input name="new_password" type="password" class="edit_prof_input_box" ng-model="newPassword" required/>
                            </div>
                            <span class='error' data-ng-show="userDetailEditForm.new_password.$invalid && userDetailEditForm.new_password.$touched"><i class='fas fa-exclamation-circle'></i> Please fill password</span>
                        </div>
                    </div>

                    </div>
                        <div class="foot_edit_prof_form">
                        <button name="update_button" type="submit"  value="Update"  class="edit_form_submit_button submitt">Update</button>
                        <a href="<?php echo $_SERVER['HTTP_REFERER']?>"><button name="cancel_button" type="button"  value="Cancel"  class="edit_form_submit_button">Cancel</button></a>
                    </div>
            
            </div> 
            </form>
            <?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>

    </body>
</html>

<script>

    var module = angular.module("userDetailEditForm", []);

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
<?php ob_end_flush();