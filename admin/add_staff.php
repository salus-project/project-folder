<?php
    require "header.php";
?>

<title> create staff</title>
<link rel="stylesheet" href="css_codes/staff.css">

<form  action="add_staff_php.php" method="POST">
<div class="create_civ_form_box">
    <div class="head_create_civ_form"> 
        <div class="head_create_civ_form_det">Create new staff</div>
    </div>
    <div class="body_create_civ_form">

    <div class="create_civ_grp">
        <label class="create_civ_form_label">First Name</label>
        <input class="create_civ_input_box" type='text'name = "first_name" placeholder="Enter first name" required>
    </div>

    <div class="create_civ_grp">
        <label class="create_civ_form_label">Last Name</label>
        <input class="create_civ_input_box" type='text'name = "last_name" placeholder="Enter last name" required>
    </div>

    <div class="create_civ_grp">
        <label class="create_civ_form_label">User Name</label>
        <input class="create_civ_input_box" type='text'name = "user_name" placeholder="Enter user name" required>
    </div>

    <div class="create_civ_grp">
        <label class="create_civ_form_label">NIC Num</label>
        <input class="create_civ_input_box" type='text'name = "nic_num" placeholder="Enter nic num" required>
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
        <label class="create_civ_form_label">Phone Number</label>
        <input class="create_civ_input_box" type='text' name = "phone_num" placeholder="Enter phone number" required>
    </div>

    <div class="create_civ_grp">
        <label class="create_civ_form_label">Email address</label>
        <input class="create_civ_input_box" type='text' name = "email_address" placeholder="Enter email address" required>
    </div>

    <div class="create_civ_grp">
        <label class="create_civ_form_label">Password</label>
        <input class="create_civ_input_box" name="password" type="password" placeholder="Enter password" required>
    </div>

</div>
<div class="foot_create_civ_form">
    <button name="update_button" type="submit"  value="Update"  class="create_civ_submit_button submitt">Submit</button>
    <a href="<?php echo $_SERVER['HTTP_REFERER']?>"><button name="cancel_button" type="button"  value="Cancel"  class="create_civ_submit_button">Cancel</button></a>
</div>
</div> 
       
<?php include $_SERVER['DOCUMENT_ROOT']."/admin/footer.php" ?>


<script>
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

