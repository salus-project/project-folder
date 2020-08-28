window.addEventListener('load', function() {
    var header = document.getElementById("menubar").parentElement;
    var side_nav = document.getElementById("side_nav_container");
    var body = document.getElementsByTagName('body')[0];
    var sticky = header.offsetTop;
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > sticky) {
            header.classList.add("sticky");
            side_nav.classList.add('fixed_side_nav');
            body.style.paddingTop = header.clientHeight + 'px';
        } else {
            header.classList.remove("sticky");
            side_nav.classList.remove('fixed_side_nav');
            body.style.paddingTop = '0'
        }
    });
    /*for (img of document.getElementsByTagName('img')) {
        img.style.visibility = 'hidden';
        img.addEventListener('load', function() {
            img.style.visibility = 'visible';
        })
    }*/
});

var btn_num;

// function btnPress(btn){
//     btn_num =btn;
//     var buttons = document.getElementsByClassName('menubar_buttons');
//     for(var item of buttons){
//         item.children[0].children[0].children[0].classList.remove('active');
//     }
//     var button = document.getElementById('menu_bar_btn_'.concat(btn));
//     button.children[0].children[0].children[0].classList.toggle('active');
// };

function btnPress(btn) {
    btn_num = btn;
    var tdd = document.getElementsByClassName('menu_icon');
    for (var item of tdd) {
        item.classList.remove('active');
    }
    document.getElementsByClassName('menu_bar_btn_'.concat(btn))[0].classList.add('active');
}

function showevent(element) {
    var tdd = document.getElementsByClassName('menu_icon');
    for (var item of tdd) {
        item.classList.remove('active');
    }
    document.getElementsByClassName('menu_bar_btn_4')[0].classList.add('active');
    getDoc(document.querySelector('#event_container'), '/event/event_list.php');
    overlay_obj.setState('opened');
}

function show_org(element) {
    var tdd = document.getElementsByClassName('menu_icon');
    for (var item of tdd) {
        item.classList.remove('active');
    }
    document.getElementsByClassName('menu_bar_btn_6')[0].classList.add('active');
    getDoc(document.querySelector('#menubar_org_container'), '/organization/org_list.php');
}

function show_notification(element) {
    var tdd = document.getElementsByClassName('menu_icon');
    for (var item of tdd) {
        item.classList.remove('active');
    }
    document.getElementsByClassName('menu_bar_btn_5')[0].classList.add('active');
    getDoc(document.querySelector('#notification_container'), '/notification/get_notification.php');
}

function getDoc(container, url) {
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            container.innerHTML = request.responseText;
            //container.style.display='block';
        }
        if (this.readyState == 1) {
            container.innerHTML = "<div class='loader'></div>";
            container.style.display = 'inline-block';
        }
    }
    request.open('GET', url, true);
    request.send();
};

function remove(element) {
    overlay_obj.setState('closed');
    /*element.parentElement.innerHTML='';*/
    btnPress(btn_num);
}

function notification_click(status, id) {
    if (status == "unseen") {
        send_str = "allow=true&id=" + id;
        var xhttp = new XMLHttpRequest();
        xhttp.open('POST', '/notification/mark.php', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(send_str);
    }
}

function notification_mark_all(){
    send_str = "all_allow=true";
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', '/notification/mark.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(send_str);

    overlay_obj.state='closed';
    overlay_obj.notifyAllObservers();
}

///////////////////////// popup observer deesign patten //////////////////////////////////////////////////////////////

class Overlay {
    constructor() {
        this.state = 'closed';
        this.observers = [];
    }

    getState() {
        return this.state;
    }

    setState(state) {
        this.state = state;
        this.notifyAllObservers();
    }

    add_observers(observer) {
        this.observers.push(observer);
    }

    notifyAllObservers() {
        for (var observer of this.observers) {
            observer.update(this);
        }
    }
}

class Popup_window {
    constructor(element) {
        this.element = element;
    }
    update(overlay) {
        if (overlay.state == 'closed') {
            this.element.innerHTML = '';
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

function show_dropdown(td) {
    td.nextElementSibling.classList.toggle('dropdown_container_active');
    td.classList.toggle('dropdown_btn_active');
    $('#main_overlay').toggleClass('show_main_overlay');
}

function hide_dropdown() {
    $('#dropdown_container').removeClass('dropdown_container_active');
    $('#main_overlay').toggleClass('show_main_overlay');
}

/////////////////////header new notification and new message

class HeaderIndicator{
    constructor(){
        this.old_notification=0;
        this.new_notification=0;
        this.old_message=0;
        this.new_message=0;
        this.noti_ele = document.getElementsByClassName('header_indicator_5')[0];
        this.message_ele = document.getElementsByClassName('header_indicator_8')[0];
        this.xhttp = new XMLHttpRequest();
        this.noti_sound=null;
        this.message_sound=null;
        this.initiated=false;
        var obj = this;
        setInterval(function(){obj.get_information(obj)}, 5000);
        window.addEventListener('click', function(){
            if(!obj.initiated){
                obj.noti_sound = new Audio('https://notificationsounds.com/soundfiles/f76a89f0cb91bc419542ce9fa43902dc/file-sounds-1154-done-for-you.mp3');
                obj.message_sound = new Audio('https://notificationsounds.com/soundfiles/8ebda540cbcc4d7336496819a46a1b68/file-sounds-1153-piece-of-cake.mp3');
                obj.initiated=true;
            }
            
        })
    }
    get_information(obje){
        obje.xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(this.responseText);
                obje.new_notification=data.notification;
                obje.new_message=data.message;
                obje.new_information_action()
            }
        };
        obje.xhttp.open("GET", "/common/header_information_ajax.php?header=1", true);
        obje.xhttp.send();
    }
    new_information_action(){
        if(this.new_notification!==this.old_notification){
            this.new_notification_action();
            this.old_notification=this.new_notification;
        }
        if(this.new_message!==this.old_message){
            this.new_message_action();
            this.old_message=this.new_message;
        }
    }
    new_notification_action(){
        if(this.new_notification==0){
            this.noti_ele.innerHTML='';
            this.noti_ele.classList.add('empty_indicator');
        }else{
            this.noti_ele.classList.remove('empty_indicator');
            this.noti_ele.innerHTML=this.new_notification;
        }if(this.new_notification>this.old_notification){
            if(this.noti_sound!==null){
                this.noti_sound.play();
            }
        }
    }
    new_message_action(){
        if(this.new_message==0){
            this.message_ele.innerHTML='';
            this.message_ele.classList.add('empty_indicator');
        }else{
            this.message_ele.classList.remove('empty_indicator');
            this.message_ele.innerHTML=this.new_message;
        }if(this.new_message>this.old_message){
            if(this.message_sound!==null){
                this.message_sound.play();
            }
        }
    }
}

var indicator = new HeaderIndicator();
document.getElementsByTagName('div')[0].click()
//indicator.init();