<?php
    require $_SERVER['DOCUMENT_ROOT']."/staff/header.php";

    $id=$_GET['event_id'];
    $query="select * from disaster_events where event_id =" . $_GET['event_id'];
    $result=($con->query($query))->fetch_assoc();
    $name=$result['name'];   
    $type=$result['type']; 
    $status_data=$result['status'];       
    $start_date=$result['start_date'];    
    $detail=$result['detail'];     
    $old_district = explode(",", $result['affected_districts']);
?>   

<link rel="stylesheet" href="/staff/css_codes/create_event.css">

<script>
    btnPress(3);
</script>

<form action="edit_event_php.php" method="POST">
    <div class="create_event_form_box">
        <div class="head_create_event_form"> 
            <div class="head_edit_prof_form_det">Edit event</div>
        </div>
        <div class="body_create_event_form">

            <div class="create_event_grp">
                <label class="create_event_label">Name</label>
                <input name = "name" type="text" class="create_event_input_box" value="<?php echo $name ?>" required>
            </div>

            <div class="create_event_grp">
                <label class="create_event_label">Type</label>
                <input name = "type" type="text" class="create_event_input_box" value="<?php echo $type ?>" required>
            </div>

            <div class="create_event_grp">
                <label class="create_event_label" name="service_area" >Afftected area</label>
                <div class="dropdown">
                    <button type="button" onclick="show_menu()"  class="dropbtn">select district/s</button>
                        <div id="myDropdown" class="dropdown-content drp">
                        <?php
                            $district_arr = array('Ampara','Anurashapura','Badulla','Batticaloa','Colombo','Galle','Gampha','Hambatota','Jaffna','Kaltura','Kandy',
                            'Kegalle','Kilinochchi','Kurunegala','Mannar','Matale','Mathara','Moneragala','Mullaitivu','Nuwara-Eliya','Polonnaruwa','Puttalam',
                            'Ratnapura','Tricomalee','Vavuniya');
                            foreach($district_arr as $dis){
                                echo "<a class='drp' data-value='$dis' onclick=select_option(this)>";
                                echo "<label class=\"container drp\">$dis";
                                if ($old_district!=''){
                                    if(in_array($dis, $old_district)){
                                        echo "<input type=\"checkbox\" class=\"drp\" name=\"district[]\" value=\"$dis\" checked=\"checked\">
                                            <span class=\"checkmark drp\"></span>
                                    </label>
                                    </a>";}
            
                                    else{echo "<input type=\"checkbox\" class=\"drp\" name=\"district[]\" value=\"$dis\" >
                                        <span class=\"checkmark drp\"></span>
                                </label>
                                </a>";
            
                                    }}
                                else{echo "<input type=\"checkbox\" class=\"drp\" name=\"district[]\" value=\"$dis\" >
                                    <span class=\"checkmark drp\"></span>
                            </label>
                            </a>";
            
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="create_event_grp">
                <label class="create_event_label"> Start date </label>                
                <input name = "start_date" type="date" class="create_event_input_box" value="<?php echo $start_date ?>" /><br>
            </div>

            <div class="create_event_grp">
                <label class="create_event_label">Details</label>
                <textarea name ="detail" type="text" class="create_event_textarea"  required><?php echo $detail ?></textarea>
            </div>

        </div>

        <div class="foot_create_event_form">
            <input type="hidden" name="event_id" value="<?php echo $id?>">
            <button name="update_button" type="submit"  value="Submit"  class="create_event_submit_button submitt">Update</button>
            <a href="<?php echo $_SERVER['HTTP_REFERER']?>"><button name="cancel_button" type="button"  value="Cancel"  class="create_event_submit_button">Cancel</button></a>
        </div>

    </div> 
</form>

<?php include $_SERVER['DOCUMENT_ROOT']."/staff/footer.php" ?>

<script>
    function show_menu() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!(event.target.matches('.dropbtn') || event.target.matches('.drp'))) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }

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