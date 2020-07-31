function OnChangeCheckbox (checkbox,text_box) {
    if (checkbox.checked) {
        document.getElementById(text_box).style.display="block"; 
    }
    else {
        document.getElementById(text_box).style.display="none"; 
    }
}
function submit_volunt(){

    var district = document.getElementsByTagName('select')[0].value;
    var help_type = [];
    if(document.getElementById('money').checked){
        help_type.push(document.getElementById('money').value);
    }
    if(document.getElementById('good').checked){
        help_type.push(document.getElementById('good').value);
    }

    var money_description = document.getElementById('money_des').value || " ";
    var good_description = document.getElementById('good_des').value || " ";

    const request = new XMLHttpRequest();

    request.onload = () => {
        console.log(request.responseText);
        /*let responseObject = null;
        try{
            responseObject = JSON.parse(request.responseText);
        }catch(e){
            console.error('Could not parse JSON');
        }
        if(responseObject){
            console.log(responseObject);
        }*/
    };
    const requestData = `event_id=`+ event_id + `&district=`+district + `&type=` + help_type + `&money_description=` + money_description + `&good_description=` + good_description + `&submit_button=` + 'submit';
    //console.log(requestData);

    request.open('post', 'request_help.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);

    help_status = 'requested';

    var html2 =     "<button id='help_request_option' disabled>Help Requested</button>" +
                    "<div id=changeRequest>"+
                        "<button class=drop_dwn name=method value=cancel onclick=cancel_request()>Cancel Request</button><br>"+
                        "<button class=drop_dwn name=method value=option onclick=request_option()>Request Option</button>"+
                    "</div>";
    help_btn.innerHTML = html2;

    document.getElementById('help_request_popup').classList.remove('active');
    overlay.classList.remove('active');
};

function add_option(){
    var table = document.getElementById("volunteer_table");
    table.innerHTML+=   "<tr>"+
                            "<td class=des_area>"+
                                "<div id=money_des_con style='display:block'>"+
                                    '<textarea cols="15" rows="1"  class="input_box" name="money_description" id="money_des"></textarea>'+
                                "</div>"+
                            "</td>"+
                            "<td class=des_area>"+
                                '<div id=money_des_con style="display:block">'+
                                    '<textarea cols="15" rows="1"  class="input_box" name="money_description" id="money_des"></textarea>'+
                                "</div>"+
                            "</td>";
}
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
function add_ability_input(element){
    var parent = element.parentElement.parentElement;
    if(element.parentElement.children[0].value!=='' || element.parentElement.children[1].value!=='') {
        for (var ele of parent.children) {
            ele.children[0].setAttribute("value", ele.children[0].value);
            ele.children[1].setAttribute("value", ele.children[1].value);
            ele.children[2].outerHTML = "<button type='button' onclick='remove_ability_input(this)' class='text_input butn'>Remove</button>"
        }
        parent.innerHTML += '<div class="input_sub_container">\n' +
        '        <input type="text" class="text_input request_input" name="item[]">\n' +
        '        <input type="text" class="text_input request_input" name="amount[]">\n' +
        '        <button type="button" onclick="add_ability_input(this)" class="text_input butn">Add</button>\n' +
        '        <input type="hidden" name="update_id[]" value="0">\n' +
        '    </div>';
    }
}
function remove_ability_input(element){
    var parent = element.nextElementSibling;
    if(parent.value!=='0'){
        document.getElementById('del_details').value+=(parent.value + ',');
    }
    element.parentElement.outerHTML='';
}