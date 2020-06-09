var allOptions = document.getElementsByTagName('option');

for(var x=0; x<allOptions.length; x++){
    if(allOptions[x].value == district_in_nic){
        allOptions[x].defaultSelected = true;
    }
}
function add_input(element){
    var parent = element.parentElement.parentElement;
    if(element.parentElement.children[0].value!=='' || element.parentElement.children[1].value!=='') {
        for (var ele of parent.children) {
            ele.children[0].setAttribute("value", ele.children[0].value);
            ele.children[1].setAttribute("value", ele.children[1].value);
            ele.children[2].outerHTML = "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>"
        }
        parent.innerHTML += '<div class="input_sub_container">\n' +
            '        <input type="text" class="text_input request_input">\n' +
            '        <input type="text" class="text_input request_input">\n' +
            '        <button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>\n' +
            '    </div>';
    }
}
function remove_input(element){
    element.parentElement.outerHTML='';
}
function edit_promise(element){
    if(element.innerHTML==="EDIT"){
        element.innerHTML="Hide Edit";
    }else{
        element.innerHTML="EDIT";
    }
    var edit_pro = document.getElementById("promise_div");
    edit_pro.classList.toggle("show_edit_div");
}