<?php //require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php"; ?>
<!DOCTYPE html>
<html>
    <head>
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
    </head>
    <body>
        <script>
            var event_name = '';
            var areaGeoJson = JSON.parse('{"type":"FeatureCollection","features":[{"type":"Feature","id":"bd4c90e7-4de3-495f-901f-b235c9b593b2","geometry":{"type":"Polygon","coordinates":[[[80.18088086,9.82667697],[80.14513104,9.82539604],[80.12108116,9.8177104],[80.08013136,9.8081031],[80.04763152,9.81578896],[80.01578168,9.81578896],[79.98198185,9.80874359],[79.95403199,9.79657396],[79.94363205,9.79337135],[79.93843207,9.7831228],[79.92218215,9.77735785],[79.9124322,9.77735785],[79.89683228,9.76646823],[79.88318235,9.76198416],[79.86498244,9.7600624],[79.8136327,9.71842152],[79.78308285,9.68638655],[79.7720329,9.67485321],[79.76553294,9.66524179],[79.76488294,9.65306694],[79.76163296,9.60884928],[79.76358295,9.59218606],[79.76878292,9.58257229],[79.85068251,9.56654873],[79.85978246,9.57039445],[79.99108181,9.59667239],[80.00343175,9.60564488],[80.00668173,9.62038488],[80.00668173,9.63127925],[80.01968166,9.64794055],[80.03918157,9.64537733],[80.04633153,9.64858135],[80.06193145,9.64153245],[80.10288125,9.61397626],[80.1321311,9.60628576],[80.20038076,9.5806495],[80.2127307,9.58513599],[80.19518079,9.59218606],[80.18673083,9.64601813],[80.24718053,9.61974403],[80.29138031,9.59346788],[80.32258015,9.57488108],[80.40187975,9.63063842],[80.36417994,9.66396025],[80.31738018,9.71521816],[80.28228035,9.76838995],[80.25043051,9.82475558],[80.2133807,9.83628373],[80.18088086,9.82667697]]]},"properties":{"name":"jaffna"}}]}');
            var location_arr = [];
            
            /*var myGeo = new EventGeo();
            myGeo.markPlace(areaGeoJson, 'danger', 'Affected area',  true);

            for(var place of location_arr){
                create_place(place);
            }*/
        </script>
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
            var event_name = '';
            var areaGeoJson = JSON.parse('{"type":"FeatureCollection","features":[{"type":"Feature","id":"bd4c90e7-4de3-495f-901f-b235c9b593b2","geometry":{"type":"Polygon","coordinates":[[[80.18088086,9.82667697],[80.14513104,9.82539604],[80.12108116,9.8177104],[80.08013136,9.8081031],[80.04763152,9.81578896],[80.01578168,9.81578896],[79.98198185,9.80874359],[79.95403199,9.79657396],[79.94363205,9.79337135],[79.93843207,9.7831228],[79.92218215,9.77735785],[79.9124322,9.77735785],[79.89683228,9.76646823],[79.88318235,9.76198416],[79.86498244,9.7600624],[79.8136327,9.71842152],[79.78308285,9.68638655],[79.7720329,9.67485321],[79.76553294,9.66524179],[79.76488294,9.65306694],[79.76163296,9.60884928],[79.76358295,9.59218606],[79.76878292,9.58257229],[79.85068251,9.56654873],[79.85978246,9.57039445],[79.99108181,9.59667239],[80.00343175,9.60564488],[80.00668173,9.62038488],[80.00668173,9.63127925],[80.01968166,9.64794055],[80.03918157,9.64537733],[80.04633153,9.64858135],[80.06193145,9.64153245],[80.10288125,9.61397626],[80.1321311,9.60628576],[80.20038076,9.5806495],[80.2127307,9.58513599],[80.19518079,9.59218606],[80.18673083,9.64601813],[80.24718053,9.61974403],[80.29138031,9.59346788],[80.32258015,9.57488108],[80.40187975,9.63063842],[80.36417994,9.66396025],[80.31738018,9.71521816],[80.28228035,9.76838995],[80.25043051,9.82475558],[80.2133807,9.83628373],[80.18088086,9.82667697]]]},"properties":{"name":"jaffna"}}]}');
            var location_arr = [];

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
    </body>
</html>