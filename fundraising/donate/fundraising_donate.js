function add_input(element){
    var parent = element.parentElement.parentElement;
    if(element.parentElement.children[0].value!=='') {
        for (var ele of parent.children) {
            ele.children[0].setAttribute("value", ele.children[0].value);
            ele.children[1].setAttribute("value", ele.children[1].value);
            ele.children[2].outerHTML = "<button type='button' onclick='remove_input(this)' class='add_rem_btn'>Remove</button>";
            if(ele.children[3].checked){
                ele.children[3].setAttribute("checked","checked");
            }
        }
        parent.innerHTML += '<div class="input_sub_container">\n' +
            '        <input type="text" class="text_input request_input" name="item[]">\n' +
            '        <input type="text" class="text_input request_input" name="amount[]">\n' +
            '        <button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>\n' +
            '        <input type="checkbox" onchange="checkbox_fun(this)">\n' +
            '        <input type="hidden" name="mark[]" value="promise">\n' +
            '        <input type="hidden" name="update_id[]" value="0">\n' +
            '    </div>';
    }
}
function remove_input(element){
    var parent = element.nextElementSibling.nextElementSibling.nextElementSibling;
    if(parent.value!=='0'){
        document.getElementById('del_detail').value+=(parent.value + ',');
    }
    element.parentElement.outerHTML='';
}
function checkbox_fun(element){
    if(element.checked){
        element.nextElementSibling.value='pending';
    }else{
        element.nextElementSibling.value='promise';
    }
}