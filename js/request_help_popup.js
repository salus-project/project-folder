var allOptions = document.getElementsByTagName('option');
var results = [];
for(var x=0; x<allOptions.length; x++){
    if(allOptions[x].value == district_in_nic){
        allOptions[x].defaultSelected = true;
    }
}

function OnChangeCheckbox (checkbox,textbox) {
    if (checkbox.checked) {
        document.getElementById(textbox).style.display="block"; 
    }
    else {
        document.getElementById(textbox).style.display="none"; 
    }
}

function submit_request(parent){

    var all_inputs= parent.getElementsByClassName("request_input");
    var requests = [];
    for(var i=0;i<all_inputs.length;i+=2){
        if(all_inputs[i].value!==''){
            requests.push(all_inputs[i].value.toLowerCase() + ":" + all_inputs[i + 1].value);
        }
    }
    var requests = requests.toString();
    var district = document.getElementById("district").value;
    var village = document.getElementById("village").value;
    var street = document.getElementById("street").value;

    const request = new XMLHttpRequest();

    request.onload = () => {
        console.log(request.responseText);
    };
    var requestData = `event_id=`+ event_id + `&district=`+ district + `&village=` + village + `&street=` + street + `&requests=`+ requests + `&submit_button=` + 'submit';
    requestData = (requestData.split(" ")).join("+");

    request.open('post', '/event/request_help.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);

    help_status = 'requested';

    var html2 =     "<button id='help_request_option' disabled>Help Requested</button>" +
                    "<div id=changeRequest>"+
                        "<button class=drop_dwn name=method value=cancel onclick=cancel_request()>Cancel Request</button><br>"+
                        "<button class=drop_dwn name=method value=option onclick=request_option()>Request Option</button>"+
                    "</div>";
    help_btn.innerHTML = html2;

    document.getElementById('popup_div').classList.remove('active_pop');
    overlay.classList.remove('active_pop');
};
function add_request_input(element){
    var parent = element.parentElement.parentElement;
    if(element.parentElement.children[0].value!=='' || element.parentElement.children[1].value!=='') {
        for (var ele of parent.children) {
            ele.children[0].setAttribute("value", ele.children[0].value);
            ele.children[1].setAttribute("value", ele.children[1].value);
            ele.children[2].outerHTML = "<button type='button' onclick='remove_input(this)' class='text_input butn'>Remove</button>"
        }
        parent.innerHTML += '<div class="input_sub_container">\n' +
        '        <input type="text" class="text_input request_input" name="item[]">\n' +
        '        <input type="text" class="text_input request_input" name="amount[]">\n' +
        '        <button type="button" onclick="add_input(this)" class="text_input butn">Add</button>\n' +
        '        <input type="hidden" name="update_id[]" value="0">\n' +
        '    </div>';
    }
}
function remove_request_input(element){
    var parent = element.nextElementSibling;
    if(parent.value!=='0'){
        document.getElementById('del_details').value+=(parent.value + ',');
    }
    element.parentElement.outerHTML='';
}