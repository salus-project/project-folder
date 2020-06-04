function OnChangeCheckbox (checkbox,text_box) {
    if (checkbox.checked) {
        document.getElementById(text_box).style.display="block"; 
    }
    else {
        document.getElementById(text_box).style.display="none"; 
    }
}