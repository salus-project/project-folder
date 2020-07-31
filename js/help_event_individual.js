function add_input(element){
    var parent = element.parentElement.parentElement;
    if(parent.firstElementChild.firstElementChild.children[0].value!=='') {
        parent.children[2].firstElementChild.outerHTML = "<button type='button' onclick='remove_input(this)' class='butn'>Remove</button>";
        parent.parentElement.innerHTML += add_element;
    }
}

function remove_input(element){
    var parent = element.parentElement.nextElementSibling;
    if(parent.value!=='0'){
        document.getElementById('del_detail').value+=(parent.value + ',');
    }
    element.parentElement.parentElement.outerHTML='';
}

function checkbox_change(element){
    element.parentElement.classList.toggle('btn-warning');
    element.parentElement.classList.toggle('off');
    element.parentElement.classList.toggle('btn-success');
    element.toggleAttribute("checked");
    if(element.checked){
        element.nextElementSibling.value='pending';
    }else{
        element.nextElementSibling.value='promise';
    }
}
function click_checkbox(ele){
    //ele.firstElementChild.toggleAttribute("checked");
    ele.firstElementChild.click();
}

function edit_event_promise(element){
    if(element.innerHTML==="EDIT"){
        element.innerHTML="Hide Edit";
    }else{
        element.innerHTML="EDIT";
    }
    var edit_pro = document.getElementById("promise_div");
    edit_pro.classList.toggle("show_edit_div");
}
function input_set(ele){
    ele.setAttribute("value", ele.value);
}