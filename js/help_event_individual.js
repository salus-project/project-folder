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
    var parent = element.parentElement.parentElement;
    remove_input(element);

    parent.innerHTML +=  'echo \'<div class=head_label_container id="old_donation"></div>\';\n'+
    'echo \'<div class="input_container">\';\n'+
    '    foreach($old_promises as $row_req){\n'+
    '        $arr = explode(":",$row_req);\n'+
    '        echo "<div class=\"input_sub_container\">";\n'+
    '        echo    "<input type=\'text\' class=\'text_input request_input\' name=\'things[]\' value=\'".$arr[0]."\'>";\n'+
    '        echo    "<input type=\'text\' class=\'text_input request_input\' name=\'things_val[]\' value=\'".$arr[1]."\'>";\n'+
    '        echo    "<button type=\'button\' onclick=\'remove_input(this)\' class=\'add_rem_btn\'>Remove</button>";\n'+
    '        echo "</div>";\n'+
    '    }\n'+
    '    echo \'<div class="input_sub_container">\';\n'+
    '        echo \'<input type="text" name="things[]" class="text_input request_input">\';\n'+
    '        echo \'<input type="text" name="things_val[]" class="text_input request_input">\';\n'+
    '        echo \'<button type="button" onclick="add_input(this)" class="add_rem_btn">Add</button>\';\n'+
    '    echo \'</div>\';\n'+
    'echo \'</div>\';\n'+
    'echo \'<div id="promise_td">\';\n'+
    '    echo\'<table>\';\n'+
    '        echo \'<tr><td><label id="note_label">Note</label></td><td><textarea col=30 rows=4 id="note" name="note"></textarea></td></tr>\';\n'+
    '    echo \'</table>\';\n'+
    'echo \'</div>\';\n'+                      
    'echo \'<div class="pro_button">\';\n'+
    '    echo \'<input name="submit_button" type="submit"  value="PROMISE"  class="submit_button" id=req_submit_btn >\';\n'+
    'echo \'</div>\';';
}