<?php 
ob_start();
require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
$nameErr=$phoneErr=''; 
require $_SERVER['DOCUMENT_ROOT'].'/organization/edit_org_php.php';

    $org_id=$_GET['org_id'];
    $by_person=$_SESSION['user_nic'];
    $query="select role FROM `org_members` WHERE org_id=".$_GET['org_id']." and NIC_num='".$by_person."' and (role='leader' or role='coleader') ;select * from organizations where org_id=".$_GET['org_id'];
    
    if(mysqli_multi_query($con,$query)){

        $result_ = mysqli_store_result($con);
        if($result_->num_rows ==0){
            header("location:".(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] :"/organization/all_org.php"));
            ob_end_flush();
            ob_flush();
            flush();
        }
        mysqli_free_result($result_);

        mysqli_next_result($con);
        $result_ = mysqli_store_result($con);
        $result= mysqli_fetch_assoc($result_);
        mysqli_free_result($result_);

        //$result=($con->query($query))->fetch_assoc();
        $org_name=$result['org_name'];
        $district=$result['district'];
        $email=$result['email'];
        $phone_num=$result['phone_num'];
        $discription=$result['discription']; 
    }
?>
<title>create new organization </title>
<link rel='stylesheet' href='/css_codes/create_org.css'>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script>
    btnPress(6);
</script>

<div id='form_main_body'>
    <div class="form_header_div">Edit Organization</div>

    <form method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' ng-app="" name="createOrgForm" id='createOrgForm' novalidate ng-init="orgName='<?php echo $org_name?>';orgMail='<?php echo $email ?>';orgNum=<?php echo $phone_num ?>">
        <div id='form_sub_body'>

            <div class="name_div">
                <label class='create_org_label'>Organization name</label>
                <div>
                    <div ng-class="{'has-error': (createOrgForm.org_name.$invalid && createOrgForm.org_name.$touched)}">
                        <input class="create_org_input" type='text' name="org_name" value='<?php echo $org_name; ?>' ng-model="orgName" required>
                    </div>
                    <span class='error'><?php echo $nameErr ?></span>
                    <span class='error' data-ng-show="createOrgForm.org_name.$invalid && createOrgForm.org_name.$touched"><i class='fas fa-exclamation-circle'></i> Name Required</span>
                </div>
            </div>

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
                        <input class="create_org_input" type='email' name="email" value='<?php echo $email; ?>' ng-model="orgMail">
                    </div>
                    <span class='error' data-ng-show="createOrgForm.email.$error.email && createOrgForm.email.$touched"><i class='fas fa-exclamation-circle'></i> Invalid Email</span>
                </div>
            </div> 

            <div class="phone_div">
                <label class="create_org_label">Phone number</label>
                <div>
                    <div ng-class="{'has-error': (createOrgForm.phone_num.$invalid && createOrgForm.phone_num.$touched)}">
                        <input class="create_org_input" type='tel' name="phone_num" value='<?php echo $phone_num; ?>' pattern="[0-9]{9}|[0-9]{10}" ng-model="orgNum">
                    </div>
                    <span class='error'><?php echo $phoneErr ?></span>
                    <span class='error' data-ng-show="createOrgForm.phone_num.$invalid && createOrgForm.phone_num.$touched"><i class='fas fa-exclamation-circle'></i> Invalid Number Format</span>
                </div>
            </div>

            <div class="discrip_div">
                <label class="create_org_label">Discription</label>
                <textarea class="create_org_textarea" name='discription'><?php echo $discription; ?></textarea>
            </div>

            
            </div>
            <div class="create_org_btn_container">
                <input type='hidden' name='org_id' value='<?php echo $org_id?>'>
                <button type='submit' name='edit_button' class="create_org_submit_btn submitt" id='submitBtn'>Edit</button>
                <a href="<?php echo $_SERVER['HTTP_REFERER']?>"><button type='button' name='cancel_button' class="create_org_cancel_btn" id='submitBtn'>Cancel</button></a>
            </div>
        
            
            
        </form>
</div>


<script>

    /*document.getElementById('createOrgForm').addEventListener('submit', (e)=>{
        for(var inps of document.getElementsBy)
        e.preventDefault();
    })*/

    var module = angular.module("createOrgForm", []);

    module.controller("formCtrl", ['$scope', function($scope){

        $scope.data = {};

    }]);

    $('#createOrgForm').submit((e)=>{
        if(($('input[name$="org_name"]:first').hasClass('ng-invalid') || $('input[name$="leader"]')[1].checked && $('input[name$="leader_nic"]:first').hasClass('ng-invalid') || $('input[name$="email"]:first').hasClass('ng-invalid') || $('input[name$="phone_num"]:first').hasClass('ng-invalid') )){
            e.preventDefault();
            alert('Please Fill the form Correctly');
        }
        
    })

    

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