
switch(safe_status){
    case 'not_set':
        var html1 = "<button id='mark' onclick='markFun()'>Mark</button>";
        break;
    case 'safe':
        var html1 = "<div class=switch_container>"+
                        "<label class='switch'>"+
                            "<input type=checkbox id=checkbox onclick=markingFun()>"+
                            "<span class=slider></span>"+
                        "</label>"+
                        "<span class=indicator id=indicator>Safe</span>"+
                    "</div>";
        break;
    case 'not_safe' :
        var html1 = "<div class=switch_container>"+
                        "<label class='switch'>"+
                            "<input type=checkbox id=checkbox onclick=markingFun() checked>"+
                            "<span class=slider></span>"+
                        "</label>"+
                        "<span class=indicator id=indicator style='background-color:rgb(231, 74, 74)'>Not Safe</span>"+
                    "</div>";
        break;
}
var safe_btn = document.getElementById('safe_btn');
safe_btn.innerHTML = html1;

switch(help_status){
    case 'not_requested':
        var html2 = "<button data-button-target='help_request_popup' id='request_help' name=method value=request onclick=request_help()>Request help</button>";
        break;

    case 'requested':
        var html2 =     "<button id='help_request_option' disabled>Help Requested</button>" +
                        "<div id=changeRequest>"+
                            "<button class=drop_dwn name=method value=cancel onclick=cancel_request()>Cancel Request</button><br>"+
                            "<button class=drop_dwn name=method value=option onclick=request_option()>Request Option</button>"+
                        "</div>";
        break;
}
var help_btn = document.getElementById('help_btn');
help_btn.innerHTML = html2;

switch(volunteer_status){
    case 'not_applied':
        var html3 = "<button id='volunteer' name=method value=apply>Help others</button>";
        break;
    case 'applied':
        var html3 =     "<button id='volunteer_option' name=event_id disabled>Volunteer Option</button>"+
                        "<div id=changeVolunteer>"+
                            "<button class='drop_dwn' name=method value=cancel>leave volunteer</button><br>"+
                            "<button class='drop_dwn'name=method value=option>Volunteer Option</button>"+
                        "</div>";
        break;
}
var volunteer_btn = document.getElementById('volunteer_btn');
volunteer_btn.innerHTML = html3;


////////////Mark as safe /////////////////////////////

function markFun(){
    mark_html=  "<div class=switch_container>"+
                    "<label class='switch'>"+
                        "<input type=checkbox id=checkbox onclick=markingFun()>"+
                        "<span class=slider></span>"+
                    "</label>"+
                    "<span class=indicator id=indicator>Safe</span>"+
                "</div>";
    
    safe_btn.innerHTML = ( mark_html );
    status='safe';
    update();
}
function markingFun(){
    var checkbox = document.getElementById('checkbox');
    var indicator = document.getElementById('indicator');
    if(checkbox.checked){
        status='not_safe';
        indicator.innerHTML = 'Not Safe';
        indicator.style.backgroundColor = 'rgb(231, 74, 74)';
        update();
    }else{
        status='safe';
        indicator.innerHTML = 'Safe';
        indicator.style.backgroundColor = 'rgb(55, 230, 84)';
        update();
    }
}
function update(){
    const request = new XMLHttpRequest();

    request.onload = () => {
        //console.log(request.responseText);
        let responseObject = null;
        try{
            responseObject = JSON.parse(request.responseText);
        }catch(e){
            console.error('Could not parse JSON');
        }
        if(responseObject){
            console.log(responseObject);
        }
    };

    const requestData = `event_id=`+ event_id + `&safe_status=`+status;

    request.open('post', 'mark_safe.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);
}

///////////////////////////////////////////


var help_people_html='<div id=requested_container>';
if(volunteer_status=='applied'){
    help_people_html +=  "<button name='help_via' value='yourselef'>Help Yourself </button></br>";
}/*else{
    help_people_html +=  "<button >Join as volunteer</button></br>";
}*/

for(org in organization){
    help_people_html += "<button name='help_via' value="+ organization[org]['org_id'] +">Help with "+ organization[org]['org_name'] +"</button></br>";
}
help_people_html +='</div>';
var requested = document.getElementsByClassName('requested');
for(div in requested){
    requested[div].innerHTML += help_people_html;
}
function help_option(element){
    var inner = element.querySelector('#requested_container');
    if(inner.style.display=='' || inner.style.display=='none'){
        inner.style.display = 'block';
    }else if(inner.style.display == 'block'){
        inner.style.display = 'none';
    }
}

//////////////////////Request help popup///////////////////////////////


const close_help_popup = document.querySelectorAll('#close_request_popup');
const overlay = document.getElementById('overlay');

function request_help(){
    const request_help_button = document.querySelector('#request_help');
    const request_help = document.querySelector('.div1');
    open_popup(request_help);
}

close_help_popup.forEach(button => {
    button.addEventListener('click',()=>{
        const request_help = button.closest('.div1')
        close_popup(request_help);
    })
})

overlay.addEventListener('click',()=>{
    const popups = document.querySelectorAll('.popup.active')
    popups.forEach(popup =>{
        close_popup(popup);
    })
})

function open_popup(request_help){
    if(request_help == null) return
    request_help.classList.add('active');
    overlay.classList.add('active');
}
function close_popup(request_help){
    if(request_help == null) return
    request_help.classList.remove('active');
    overlay.classList.remove('active');
}

//////////////////////////////////////////////////////////
function cancel_request(){
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

    const requestData = `event_id=`+ event_id + `&cancel_button=button`;

    request.open('post', 'request_help.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);

    help_status = 'not_requested';
    var html2 = "<button data-button-target='help_request_popup' id='request_help' name=method value=request onclick=request_help()>Request help</button>";
    help_btn.innerHTML = html2;
}

function request_option(){
    const request_help = document.querySelector('.div1');
    open_popup(request_help);
    var req_submit_btn = document.getElementById('req_submit_btn');
    
}