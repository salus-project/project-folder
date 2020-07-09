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
        var html3 = "<button id='volunteer' name='method' value='apply' onclick='volunteer_btn_click(\"apply\")'>Help others</button>";
        break;
    case 'applied':
        var html3 =     "<button id='volunteer_option' name=event_id disabled>Volunteer Option</button>"+
                        "<div id=changeVolunteer>"+
                            "<button class='drop_dwn' name=method value=cancel onclick='volunteer_btn_click(\"cancel\")'>leave volunteer</button><br>"+
                            "<button class='drop_dwn'name=method value=option onclick='volunteer_btn_click(\"option\")'>Volunteer Option</button>"+
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

    request.open('post', '/event/mark_safe.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);
}

///////////////////////////////////////////


var requested = document.getElementsByClassName('requested');
for(div of requested){

    var help_people_html ='<div id=requested_container>';
    if(volunteer_status=='applied'){
        help_people_html +=  "<a href='/event/help?event_id="+event_id+"&by=your_self&to="+div.previousElementSibling.value+"' ><button>Help Yourself </button></a></br>";
    }/*else{
    help_people_html +=  "<button >Join as volunteer</button></br>";
    }*/

    for(org of organization){
        help_people_html += "<a href='/event/help?event_id="+event_id+"&by="+org['org_id']+"&org_name="+org['org_name']+"&event="+event_id+"&to="+div.previousElementSibling.value+"'><button>Help with "+ org['org_name'] +"</button></a></br>";
    }
    help_people_html +='</div>';
    div.innerHTML += help_people_html;
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
    open_popup("/event/request_help_popup.php?event_id="+event_id);
}

close_help_popup.forEach(button => {
    button.addEventListener('click',()=>{
        const request_help = button.closest('.div1')
        close_popup(request_help);
    })
})

overlay.addEventListener('click',()=>{
    const popups = document.querySelectorAll('.popup.active_pop')
    popups.forEach(popup =>{
        close_popup(popup);
    })
})

function open_popup(url){
    const popup = document.getElementById('popup_div');
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            popup.innerHTML =  this.responseText;
            popup.style.display = "block";
            for( i of popup.getElementsByTagName('script')){
                eval(i.innerHTML);
                console.log(i.innerHTML);
            }
        }
        if(this.readyState == 1){
            popup.innerHTML =  "<div class='popup_loader'></div>";
            popup.style.display = "flex";
        }
    };
    xhttp.open('GET', url,true);
    xhttp.send();
    if(popup == null) return
    popup.classList.add('active_pop');
    overlay.classList.add('active_pop');
}
function close_popup(request_help){
    if(request_help == null) return
    request_help.classList.remove('active_pop');
    overlay.classList.remove('active_pop');
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

    request.open('post', '/event/request_help.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);

    help_status = 'not_requested';
    var html2 = "<button data-button-target='help_request_popup' id='request_help' name=method value=request onclick=request_help()>Request help</button>";
    help_btn.innerHTML = html2;
}

function request_option(){
    open_popup("/event/request_help_popup.php?event_id="+event_id);
    var req_submit_btn = document.getElementById('req_submit_btn');
}

///////////// Volunteer button //////////////////////////////////

function volunteer_btn_click(method){
    const url = "/event/volunteer_application.php?event_id="+event_id+"&method="+method;
    open_popup(url);
}



////////////////////////help request popup /////////////////////////////////////////
