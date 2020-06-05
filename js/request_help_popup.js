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

function submit_request(){

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

    document.getElementById('popup_div').classList.remove('active_pop');
    overlay.classList.remove('active_pop');
};