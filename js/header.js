var header = document.getElementById("menubar").parentElement;
var body = document.getElementsByTagName('body')[0];
var sticky = header.offsetTop;
window.onscroll = function(){
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
        body.style.paddingTop = header.clientHeight+'px';
    } else {
        header.classList.remove("sticky");
        body.style.paddingTop = '0'
    }
}
var btn_num;
function btnPress(btn){
    btn_num =btn;
    var buttons = document.getElementsByClassName('menubar_buttons');
    for(var item of buttons){
        item.classList.remove('active');
    }
    var button = document.getElementById('menu_bar_btn_'.concat(btn));
    button.classList.toggle('active');
};
function showevent(element){
    var buttons = document.getElementsByClassName('menubar_buttons');
    for(var item of buttons){
        item.classList.remove('active');
    }
    var button = document.getElementById('menu_bar_btn_4');
    button.classList.toggle('active');
    getDoc(document.querySelector('#event_container'),'/event/event_list.php');
    overlay_obj.setState('opened');
}
function show_org(element){
    var buttons = document.getElementsByClassName('menubar_buttons');
    for(var item of buttons){
        item.classList.remove('active');
    }
    var button = document.getElementById('menu_bar_btn_6');
    button.classList.toggle('active');
    getDoc(document.querySelector('#menubar_org_container'),'/organization/org_list.php');
}
function show_notification(element){
    var buttons = document.getElementsByClassName('menubar_buttons');
    for(var item of buttons){
        item.classList.remove('active');
    }
    var button = document.getElementById('menu_bar_btn_5');
    button.classList.toggle('active');
    getDoc(document.querySelector('#notification_container'),'/notification/get_notification.php');
}
function getDoc(container,url){
    const request = new XMLHttpRequest();
    request.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            container.innerHTML=request.responseText;
            //container.style.display='block';
        }if(this.readyState == 1){
            container.innerHTML="<div class='loader'></div>";
            container.style.display='inline-block';
        }
    }
    request.open('GET',url,true);
    request.send();
};
function remove(element){
    overlay_obj.setState('closed');
    /*element.parentElement.innerHTML='';*/
    btnPress(btn_num);
}

function notification_click(status, id){
    if(status=="unseen"){
        send_str="allow=true&id="+id;
        var xhttp = new XMLHttpRequest();
            xhttp.open('POST', '/notification/mark.php',true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(send_str);
    }
}

///////////////////////// popup observer deesign patten //////////////////////////////////////////////////////////////

class Overlay{
    constructor(){
        this.state='closed';
        this.observers = [];
    }

    getState(){
        return this.state;
    }

    setState(state){
        this.state = state;
        this.notifyAllObservers();
    }

    add_observers(observer){
        this.observers.push(observer);
    }

    notifyAllObservers(){
        for(var observer of this.observers){
            observer.update(this);
        }
    }
}

class Popup_window{
    constructor(element){
        this.element = element;
    }
    update(overlay){
        if(overlay.state=='closed'){
            this.element.innerHTML='';
        }
    }
}
let overlay_obj = new Overlay()
var event_container_obj = new Popup_window(document.getElementById('event_container'));
var notification_container_obj = new Popup_window(document.getElementById('notification_container'));
var organization_container_obj = new Popup_window(document.getElementById('menubar_org_container'));

overlay_obj.add_observers(event_container_obj);
overlay_obj.add_observers(notification_container_obj);
overlay_obj.add_observers(organization_container_obj);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////