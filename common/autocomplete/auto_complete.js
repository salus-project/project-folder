function autocomplete_ready(ele, type, touch_ele = null, link = '') {
    ele.style.position = 'relative';
    var clicked = false;
    var inp_ele = document.createElement('INPUT');
    inp_ele.setAttribute('class', 'autocomplete_text_inp');
    inp_ele.setAttribute('spellcheck', 'false');
    inp_ele.setAttribute('autocomplete', 'off');
    inp_ele.setAttribute('placeholder', 'Search here');
    ele.appendChild(inp_ele);
    if (touch_ele == null) {
        touch_ele = inp_ele;
    } else if (touch_ele === 'ready') {
        load_data(inp_ele, type, link);
    } else {



        touch_ele.addEventListener('click', function() {
            if (!clicked) {
                load_data(inp_ele, type, link);

            }
        });
    }
}

function load_data(inp_ele, type, link) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            autocomplete(inp_ele, data, link);
        }
        if (this.readyState == 1) {
            //tag_content.innerHTML = 'Wait';
        }
    };
    xhttp.open('GET', '/common/autocomplete/ajax.php?get=' + type, true);
    xhttp.send();
    clicked = true;
}

function autocomplete(inp, inp_arr, link) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    arr = inp_arr;
    for(ele of arr){
        ele.loop_arr = splitAllWays([], [], ele['showname']);
    }
    arr = inp_arr;
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false; }
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        var tem=[];
        for (i = 0; i < arr.length; i++) {
            tem = arr[i]['loop_arr'];
            for (j = 0; j < tem.length; j++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (tem[j][1].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    b.setAttribute("data-select", "true");
                    /*make the matching letters bold:*/
                    var html = "<div class='autocomplete_img_cont'><img class='autocomplete_img' src='" + arr[i]['img_src'] + "' onload='{this.style.visibility=\"visible\"}'></div> ";
                    html += tem[j][0];
                    html += "<strong>" + tem[j][1].substr(0, val.length) + "</strong>";
                    html += tem[j][1].substr(val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    html += "<input type='hidden' value='" + arr[i]['showname'] + "'><input type='hidden' value='" + arr[i]['link'] + "'><input type='hidden' value='" + arr[i]['value'] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.innerHTML = html;
                    b.addEventListener("click", function(e) {
                        /*insert the value for the autocomplete text field:*/
                        if (link === '') {
                            inp.value = this.getElementsByTagName("input")[0].value;
                            inp.nextElementSibling.value = this.getElementsByTagName("input")[1].value;
                        } else if (link === 'auto') {

                        } else {
                            window.location.href = link + this.getElementsByTagName("input")[2].value;
                        }
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                    break;
                }
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.querySelectorAll("div[data-select]");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function(e) {
        closeAllLists(e.target);
    });

    
}

function splitAllWays(result, left, right){
    arr = right.split(' ');
    // Push current left + right to the result list
    
    result.push([(left.join(' ')==='')?'':left.join(' ')+' '].concat(right));
    //document.write(left.concat(right) + '<br />');

    // If we still have chars to work with in the right side then keep splitting
    if (arr.length > 1){
      // For each combination left/right split call splitAllWays()
      for(var i = 1; i < arr.length; i++){
        splitAllWays(result, left.concat((arr.slice(0, i)).join(' ')), (arr.slice(i)).join(' '));
      }
    }

    // Return result
    return result;
};