var allOptions = document.getElementsByTagName('option');
var results = [];
for (var x = 0; x < allOptions.length; x++) {
    if (allOptions[x].value == district_in_nic) {
        allOptions[x].defaultSelected = true;
    }
}

function OnChangeCheckbox(checkbox, textbox) {
    if (checkbox.checked) {
        document.getElementById(textbox).style.display = "block";
    } else {
        document.getElementById(textbox).style.display = "none";
    }
}

/*function submit_request(parent) {
    address_to_cord_click();
    var all_inputs = parent.getElementsByClassName("request_input");
    var requests = [];
    for (var i = 0; i < all_inputs.length; i += 2) {
        if (all_inputs[i].value !== '') {
            requests.push(all_inputs[i].value.toLowerCase() + ":" + all_inputs[i + 1].value);
        }
    }
    var requests = requests.toString();
    var district = document.getElementById("req_district").value;
    var village = document.getElementById("village").value;
    var street = document.getElementById("street").value;
    var lat =document.getElementById('lat').value;
    var lng=document.getElementById('lng').value;
    const request = new XMLHttpRequest();
    request.onload = () => {
        console.log(request.responseText);
    };
    var requestData = `event_id=` + event_id + `&district=` + district + `&village=` + village + `&street=` + street + `&requests=` + requests +  `&lat=` + lat + `&lng=` + lng + `&submit_button=` + 'submit';
    requestData = (requestData.split(" ")).join("+");
    request.open('post', '/event/request_help.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);
    help_status = 'requested';
    var html2 = "<button id='help_request_option' disabled>Help Requested</button>" +
        "<div id=changeRequest>" +
        "<button class=drop_dwn name=method value=cancel onclick=cancel_request()>Cancel Request</button><br>" +
        "<button class=drop_dwn name=method value=option onclick=request_option()>Request Option</button>" +
        "</div>";
    help_btn.innerHTML = html2;
    document.getElementById('popup_div').classList.remove('active_pop');
    overlay.classList.remove('active_pop');
};*/
 
function add_request_input(element) {
    var parent = element.parentElement.parentElement;
    if (element.parentElement.children[0].value !== '' || element.parentElement.children[1].value !== '') {
        for (var ele of parent.children) {
            ele.children[0].setAttribute("value", ele.children[0].value);
            ele.children[1].setAttribute("value", ele.children[1].value);
            ele.children[2].outerHTML = "<button type='button' onclick='remove_request_input(this)' class='text_input butn'>Remove</button>"
        }
        parent.innerHTML += '<div class="input_sub_container">\n' +
            '        <input type="text" class="text_input request_input" name="item[]">\n' +
            '        <input type="text" class="text_input request_input" name="amount[]">\n' +
            '        <button type="button" onclick="add_request_input(this)" class="text_input butn">Add</button>\n' +
            '        <input type="hidden" name="update_id[]" value="0">\n' +
            '    </div>';
    }
}

function remove_request_input(element) {
    var parent = element.nextElementSibling;
    if (parent.value !== '0') {
        document.getElementById('del_details').value += (parent.value + ',');
    }
    element.parentElement.outerHTML = '';
}

/*                 map                    */
var reqGeo;
function init_request_map(){
    var event_name = '';
    var areaGeoJson = JSON.parse('{"type":"FeatureCollection","features":[{"type":"Feature","id":"bd4c90e7-4de3-495f-901f-b235c9b593b2","geometry":{"type":"Polygon","coordinates":[[[80.18088086,9.82667697],[80.14513104,9.82539604],[80.12108116,9.8177104],[80.08013136,9.8081031],[80.04763152,9.81578896],[80.01578168,9.81578896],[79.98198185,9.80874359],[79.95403199,9.79657396],[79.94363205,9.79337135],[79.93843207,9.7831228],[79.92218215,9.77735785],[79.9124322,9.77735785],[79.89683228,9.76646823],[79.88318235,9.76198416],[79.86498244,9.7600624],[79.8136327,9.71842152],[79.78308285,9.68638655],[79.7720329,9.67485321],[79.76553294,9.66524179],[79.76488294,9.65306694],[79.76163296,9.60884928],[79.76358295,9.59218606],[79.76878292,9.58257229],[79.85068251,9.56654873],[79.85978246,9.57039445],[79.99108181,9.59667239],[80.00343175,9.60564488],[80.00668173,9.62038488],[80.00668173,9.63127925],[80.01968166,9.64794055],[80.03918157,9.64537733],[80.04633153,9.64858135],[80.06193145,9.64153245],[80.10288125,9.61397626],[80.1321311,9.60628576],[80.20038076,9.5806495],[80.2127307,9.58513599],[80.19518079,9.59218606],[80.18673083,9.64601813],[80.24718053,9.61974403],[80.29138031,9.59346788],[80.32258015,9.57488108],[80.40187975,9.63063842],[80.36417994,9.66396025],[80.31738018,9.71521816],[80.28228035,9.76838995],[80.25043051,9.82475558],[80.2133807,9.83628373],[80.18088086,9.82667697]]]},"properties":{"name":"jaffna"}}]}');
    var location_arr = [];

    reqGeo = new EventGeo('requester_map_container');
    reqGeo.markPlace(areaGeoJson, 'danger', 'Affected area',  true);

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position)=>{
            set_location_input(position.coords.latitude, position.coords.longitude);
            fill_address_click();
        });
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }

    (document.getElementsByClassName('leaflet-control-attribution leaflet-control')[0]).style.display='none';
    for(var x of document.getElementsByClassName('ol-attribution')){
        x.style.display='none';
    };

    window.dispatchEvent(new Event('resize', { 'bubbles': true }));
    window.setTimeout(()=>{
        reqGeo.fit_screen();
    },1);
}

function locate_current(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position)=>{
            var southWest = new L.LatLng(position.coords.latitude-0.01, position.coords.longitude-0.01),
            northEast = new L.LatLng(position.coords.latitude+0.01, position.coords.longitude+0.01),
            bounds = new L.LatLngBounds(southWest, northEast);
            reqGeo.bound_map(bounds);
            
            set_location_input(position.coords.latitude, position.coords.longitude);
            update_preview();
        });
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function set_location_input(x,y){
    document.getElementById('lat').value=x;
    document.getElementById('lng').value=y;
}

var event=false;
function mark_custom(element){
    if(!event){
        reqGeo.add_event('click',onMapClick);
        element.style.backgroundColor='#a1daff';
        event=true;
    }else{
        reqGeo.remove_event('click',onMapClick);
        element.style.backgroundColor='initial';
        event=false;
    }
    
    
}
function onMapClick(e){
    reqGeo.addMarkerLayer(e.latlng);
    if(inside(e.latlng, areaGeoJson)){
        set_location_input(e.latlng.lat, e.latlng.lng);
    }else{
        alert('This area not belongs to affected area');
    }
}

function preview(element){
    if(element.classList.contains('preview')){
        element.classList.remove('preview');
        reqGeo.addMarkerLayer({lat:document.getElementById('lat').value, lng:document.getElementById('lng').value});
    }else{
        var e = document.getElementById("select_type");
        reqGeo.addMarkerLayer({lat: document.getElementById('lat').value, lng: document.getElementById('lng').value}, e.options[e.selectedIndex].value,"marked by you");
        element.classList.add('preview');
    }
}

function update_preview(){
    var btn = document.getElementById('preview_btn');
    if(btn.classList.contains('preview')){
        var e = document.getElementById("select_type");
        reqGeo.addMarkerLayer({lat: document.getElementById('lat').value, lng: document.getElementById('lng').value}, e.options[e.selectedIndex].value,"marked by you");
    }
}

function fill_address_click(){
    get_from_google('latlng='+document.getElementById('lat').value+','+document.getElementById('lng').value, fill_address);
}
function address_to_cord_click(){
    var add = [].concat(document.getElementById("req_district").value.split(' '),document.getElementById("village").value.split(' '),document.getElementById("street").value.split(' '));
    get_from_google('address='+add.join('+'), mark_from_address);
}

function get_from_google(data, c_function){
    var url = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCR5PFyvraK8Cqbu-vQu7UAR-NkcABHNuw&'+data;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            c_function(JSON.parse(this.responseText));
        }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
}

function fill_address(res){
    var dis='';
    var vill=[];
    var str=[];
    for(var row_res of res.results){
        for(var add of row_res.address_components){
            if(add.types.includes("administrative_area_level_2")){
                dis=add.long_name;
                
            }else if(add.types.includes("locality") ||  add.types.includes("administrative_area_level_3") || add.types.includes("administrative_area_level_4")){
                vill.push(add.long_name);
            }else if(add.types.includes("route")){
                str.push(add.long_name);
            }
        }
    }

    document.getElementById("req_district").value=dis;
    document.getElementById("village").value=(vill.filter(function(value, index, self){return self.indexOf(value) === index;})).join(', ')
    document.getElementById("street").value=(str.filter(function(value, index, self){return self.indexOf(value) === index;})).join(', ')
    
}

function mark_from_address(res){
    reqGeo.addMarkerLayer(res.results[0].geometry.location);
}

function change_option(option){
    var address = document.getElementById('radio_address');
    var location = document.getElementById('radio_location');

    var address_container = document.getElementById('requester_detail_address_cont');
    var location_container = document.getElementById('requester_detail_location_cont');

    switch (option){
        case 'address':
            address.checked=true;
            address.parentElement.classList.add('active_option');
            location.parentElement.classList.remove('active_option');

            address_container.classList.add('show_container');
            location_container.classList.remove('show_container');
            break;
        case 'location':
            location.checked=true;
            location.parentElement.classList.add('active_option');
            address.parentElement.classList.remove('active_option');

            location_container.classList.add('show_container');
            address_container.classList.remove('show_container');
    }
}