<?php require $_SERVER['DOCUMENT_ROOT']."/organization/event/org_event_header.php" ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
<link rel="stylesheet" href="/css_codes/organization_event_mark_area.css">
<link href="/common/map/vector_editor.css?t=1593079387" rel="stylesheet" />
<script src="/common/map/map.js"></script>
<style>
    #map_container{
        box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19)
    }
    #map_container{
        margin:auto;
        width: 90%;
        height: 500px;
        margin-top:25px;
    }
    #circle_map{
        height: 100%;
        width: 100%;
    }
    .map_form_container{
        display:none;
        min-height:150px;
    }
    .show_container{
        display:block;
    }
    /*#map-ol{
        height:500px;
    }*/
    #form{
        margin: auto;
        width: 600px;
        text-align: center;
        box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
        margin-bottom: 25px;
        margin-top:25px;
    }
    .map_button{
        height: 50px;
        width: 200px;
        text-decoration: none;
        border-collapse: collapse;
        border-spacing: 0;
        font-family: inherit;
        font-size: 12.5px;
        color: #393939;
        padding: 16px;
        display: table-cell;
        border: 1px solid #d8e0e7;
        line-height: 1;
        vertical-align: middle;
        cursor:pointer;
    }
    #content_container{
        min-height: 150px;
    }
    #sub_btn_container{
        font-size: 0;
        padding-top: 10px;
    }
    .sub_btn{
        width: 300px;
        height: 50px;
        text-decoration: none;
        border-collapse: collapse;
        border-spacing: 0;
        font-family: inherit;
        font-size: 16px;
        color: #393939;
        padding: 16px;
        display: table-cell;
        border: 1px solid #d8e0e7;
        line-height: 1;
        vertical-align: middle;
        cursor: pointer;
        background-color: #0c7dff47;
    }
    .preview{
        background-color: rgb(161, 218, 255);
    }
    .form_td{
        width:300px;
    }
    .active_option{
        background-color: rgb(161, 218, 255);
    }
</style>
<div id='map_container'>
</div>

<div id='form'>
    <form method='post' action='mark.php'>
        <input type='hidden' name='event_id' value='<?php echo $_GET['event_id'] ?>'>
        <label><h2>Enter Detail</h2></label>
        <div id='content_container'>
                <div id='button_container'>
                    <button type='button' class='map_button' onclick='locate_current()'>Locate your current position</button>
                    <button type='button' class='map_button' onclick='mark_custom(this)'>Mark a custom position</button><br/>
                    <label>Mark the area on the map</label><br/>
                    <input type='hidden' name='latitude' id='lat'>
                    <input type='hidden' name='longitude' id='lng'>
                </div>
        </div>

        <span>Place type</span>
        <div class="custom-select" style="width:200px;">
            <select id="select_type" name="select_type">
                <option value="0">Select option:</option>
                <option value="medical" >Medical Camp</option>
                <option value="donation">Donation Center</option>
                <option value="other">Other</option>
                
            </select>
        </div><br>

        <span>Details</span>
        <textarea id='detail' name='detail'></textarea>
        <div id='sub_btn_container'>
            <button type='button' class='sub_btn' onclick='submit_form()'>Submit</button>
            <button type='button' class='sub_btn' onclick='preview(this)' id='preview_btn'>Preview</button>
        </div>
        <input type='hidden' name='org_id' value='<?php echo $_GET['org_id']; ?>'>
    </form>
    
</div>
<script>

    var myGeo = new EventGeo('map_container');
    myGeo.markPlace(areaGeoJson, 'danger', 'Affected area',  true);

    for(var place of location_arr){
        create_place(place);
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position)=>{
            set_location_input(position.coords.latitude, position.coords.longitude);
        });
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
    

    function locate_current(){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position)=>{
                var southWest = new L.LatLng(position.coords.latitude-0.01, position.coords.longitude-0.01),
                northEast = new L.LatLng(position.coords.latitude+0.01, position.coords.longitude+0.01),
                bounds = new L.LatLngBounds(southWest, northEast);
                myGeo.bound_map(bounds);
                
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
            myGeo.add_event('click',onMapClick);
            element.style.backgroundColor='#a1daff';
            event=true;
        }else{
            myGeo.remove_event('click',onMapClick);
            element.style.backgroundColor='initial';
            event=false;
        }
        
        
    }
    function onMapClick(e){
        myGeo.addMarkerLayer(e.latlng);
        if(inside(e.latlng, areaGeoJson)){
            set_location_input(e.latlng.lat, e.latlng.lng);
        }else{
            alert('This area not belongs to affected area');
        }
    }
    

    function submit_form(){
        if(document.getElementById('select_type').selectedIndex!==0){
                document.getElementById('form').firstElementChild.submit();
        }else{
            alert('Please select Place type');
        }
    }

    function preview(element){
        if(element.classList.contains('preview')){
            element.classList.remove('preview');
            myGeo.addMarkerLayer({lat:document.getElementById('lat').value, lng:document.getElementById('lng').value});
        }else{
            var e = document.getElementById("select_type");
            myGeo.addMarkerLayer({lat: document.getElementById('lat').value, lng: document.getElementById('lng').value}, e.options[e.selectedIndex].value,"marked by you");
            element.classList.add('preview');
        }
    }

    function update_preview(){
        var btn = document.getElementById('preview_btn');
        if(btn.classList.contains('preview')){
            var e = document.getElementById("select_type");
            myGeo.addMarkerLayer({lat: document.getElementById('lat').value, lng: document.getElementById('lng').value}, e.options[e.selectedIndex].value,"marked by you");
        }
    }

    (document.getElementsByClassName('leaflet-control-attribution leaflet-control')[0]).style.display='none';
    for(var x of document.getElementsByClassName('ol-attribution')){
        x.style.display='none';
    };


    var x, i, j, l, ll, selElmnt, a, b, c;
    /*look for any elements with the class "custom-select":*/
    x = document.getElementsByClassName("custom-select");
    l = x.length;
    for (i = 0; i < l; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    ll = selElmnt.length;
    /*for each element, create a new DIV that will act as the selected item:*/
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
    /*for each element, create a new DIV that will contain the option list:*/
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 1; j < ll; j++) {
        /*for each option in the original select element,
        create a new DIV that will act as an option item:*/
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function(e) {
            /*when an item is clicked, update the original select box,
            and the selected item:*/
            var y, i, k, s, h, sl, yl;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            sl = s.length;
            h = this.parentNode.previousSibling;
            for (i = 0; i < sl; i++) {
            if (s.options[i].innerHTML == this.innerHTML) {
                s.selectedIndex = i;
                h.innerHTML = this.innerHTML;
                y = this.parentNode.getElementsByClassName("same-as-selected");
                yl = y.length;
                for (k = 0; k < yl; k++) {
                y[k].removeAttribute("class");
                }
                this.setAttribute("class", "same-as-selected");
                break;
            }
            }
            h.click();
            update_preview();
        });
        b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function(e) {
        /*when the select box is clicked, close any other select boxes,
        and open/close the current select box:*/
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
        });
    }
    function closeAllSelect(elmnt) {
    /*a function that will close all select boxes in the document,
    except the current select box:*/
    var x, y, i, xl, yl, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    xl = x.length;
    yl = y.length;
    for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
        arrNo.push(i)
        } else {
        y[i].classList.remove("select-arrow-active");
        }
    }
    for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i)) {
        x[i].classList.add("select-hide");
        }
    }
    }
    /*if the user clicks anywhere outside the select box,
    then close all select boxes:*/
    document.addEventListener("click", closeAllSelect);
</script>
<?php require $_SERVER['DOCUMENT_ROOT']."/organization/org_footer.php"; ?>