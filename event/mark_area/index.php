<?php
    require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php"; ?>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
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
        <script>
            var event_name = '';
            var areaGeoJson = JSON.parse('{"type":"FeatureCollection","features":[{"type":"Feature","id":"bd4c90e7-4de3-495f-901f-b235c9b593b2","geometry":{"type":"Polygon","coordinates":[[[80.18088086,9.82667697],[80.14513104,9.82539604],[80.12108116,9.8177104],[80.08013136,9.8081031],[80.04763152,9.81578896],[80.01578168,9.81578896],[79.98198185,9.80874359],[79.95403199,9.79657396],[79.94363205,9.79337135],[79.93843207,9.7831228],[79.92218215,9.77735785],[79.9124322,9.77735785],[79.89683228,9.76646823],[79.88318235,9.76198416],[79.86498244,9.7600624],[79.8136327,9.71842152],[79.78308285,9.68638655],[79.7720329,9.67485321],[79.76553294,9.66524179],[79.76488294,9.65306694],[79.76163296,9.60884928],[79.76358295,9.59218606],[79.76878292,9.58257229],[79.85068251,9.56654873],[79.85978246,9.57039445],[79.99108181,9.59667239],[80.00343175,9.60564488],[80.00668173,9.62038488],[80.00668173,9.63127925],[80.01968166,9.64794055],[80.03918157,9.64537733],[80.04633153,9.64858135],[80.06193145,9.64153245],[80.10288125,9.61397626],[80.1321311,9.60628576],[80.20038076,9.5806495],[80.2127307,9.58513599],[80.19518079,9.59218606],[80.18673083,9.64601813],[80.24718053,9.61974403],[80.29138031,9.59346788],[80.32258015,9.57488108],[80.40187975,9.63063842],[80.36417994,9.66396025],[80.31738018,9.71521816],[80.28228035,9.76838995],[80.25043051,9.82475558],[80.2133807,9.83628373],[80.18088086,9.82667697]]]},"properties":{"name":"jaffna"}}]}');
            var location_arr = [];
        </script>
        <div id='map_container'>
            <div id='circle_map' style='display:none'>
            </div>
            <div id='area_selector' style='display:block;height:500px'>
                <?php require $_SERVER['DOCUMENT_ROOT']."/common/map/maptiler-vector.html"; ?>
            </div>
        </div>

        
        
        <div id='form'>
            <form method='post' action='/event/mark_area/mark.php'>
                <input type='hidden' name='event_id' value='<?php echo $_GET['event_id'] ?>'>
                <table>
                    <tr>
                        <td onclick='change_option("area")' class='form_td active_option'>
                            <input type='radio' name='mark' id='geoJson' value='geoJson' checked='checked' style='display:none'>
                            <label for='geoJson'>GeoJSON</label>
                        </td>
                        <td onclick='change_option("circle")' class='form_td'>
                            <input type='radio' name='mark' id='circle' value='circle'  style='display:none'>
                            <label for='circle'>Circle</label>
                        </td>
                    </tr>
                </table>
                <div id='content_container'>
                    <div id='circle_container' class='map_form_container'>
                        <div id='button_container'>
                            <button type='button' class='map_button' onclick='locate_current()'>Locate your current position</button>
                            <button type='button' class='map_button' onclick='mark_custom(this)'>Mark a custom position</button><br/>
                            <label>Mark the area on the map</label><br/>
                            <input type='hidden' name='latitude' id='lat'>
                            <input type='hidden' name='longitude' id='lng'>
                            <label>Round Radius</label>
                            <input type='number' name='radius' min='1' max='5000' value='100' id='rad' required>
                            <label>m</label>
                        </div>
                    </div>
                    <div id='geoJson_container' class='map_form_container show_container'>
                        <label>Select the area on the map</label>
                        <input type='hidden' name='geoJson' id='geoJson_input'>
                    </div>
                </div>
                <span>Details</span>
                <textarea id='detail' name='detail'></textarea>

                <div id='sub_btn_container'>
                    <button type='button' class='sub_btn' onclick='submit_form()'>Submit</button>
                    <button type='button' class='sub_btn' onclick='preview(this)' id='preview_btn'>Preview</button>
                </div>
            </form>
            
        </div>
        <script>
            var myGeo = new EventGeo('circle_map');
            myGeo.markPlace(areaGeoJson, 'danger', 'Affected area',  true);

            for(var place of location_arr){
                create_place(place);
            }
            /*class AreaStyle{
                constructor(){
                    
                }
                create(area){
                    switch (area) {
                        case 'danger':
                            this.fillColor='red';
                            this.color='red';
                            this.weight = 3;
                            this.opacity = 0.3;
                            this.fillOpacity = 0.08;
                            break;
                        case 'suggested':
                            this.fillColor='organge';
                            this.color='orange';
                            this.weight = 3;
                            this.opacity = 0.3;
                            this.fillOpacity = 0.08;
                            break;
                    }
                    return {"fillColor":this.fillColor,
                        "color":this.color,
                        "weight": this.weight,
                        "opacity": this.opacity,
                        "fillOpacity": this.fillOpacity}
                }
            }
            
            class EventGeo{
                constructor(x=0,y=0,zoom=12){
                    this.map = L.map('map').setView([x, y],zoom);
                    L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=fN8T3G0qqLvrBTjTZJfJ'/*, {
                        attribution:'<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
                        
                    }*//*).addTo(this.map);

                    this.customMarker = L.icon({
                        iconUrl:'/common/markers/marker1.png',
                        iconSize:[38,40],
                        iconAnchor:[19,40]
                    });

                    this.areaObj = new AreaStyle();
                    this.markerLayer=null;
                    this.markers = [];
                    this.places = [];
                }
                addMarker(x,y,msg){
                    this.marker = L.marker([x, y],{icon:this.customMarker, draggable:false}).addTo(this.map);
                    this.marker.bindPopup(msg);
                    this.markers.push(this.marker);
                }
                addMarkerLayer(xy,msg){
                    if(this.markerLayer!==null){
                        this.map.removeLayer(this.markerLayer);
                    }
                    this.markerLayer = L.marker(xy,{icon:this.customMarker, draggable:false});
                    this.map.addLayer(this.markerLayer);
                    this.markerLayer.bindPopup(msg);
                }
                markPlace(geoJson, msg, area, center){
                    this.place = L.geoJSON(geoJson,{
                        style: this.areaObj.create(area)
                    }).addTo(this.map);
                    this.place.bindPopup(msg);
                    if(center){
                        this.map.fitBounds(this.place.getBounds());
                    }
                    this.places.push(this.place);
                }

                draw_circle(x, y, rad, msg, center=false){
                    this.circle = L.circle([x, y], {
                        color: 'orange',
                        fillColor: 'orange',
                        fillOpacity: 0.3,
                        weight: 0.1,
                        radius: rad
                    }).addTo(this.map);
                    this.circle.bindPopup(msg);
                    if(center){
                        this.map.fitBounds(this.circle.getBounds());
                    }
                }

                bound_map(bounds){
                    this.map.fitBounds(bounds);
                }

                add_event(event,fun){
                    this.map.on(event, fun);
                    for(var place of this.places){
                        place.on(event, fun);
                        place.unbindPopup();
                    }
                }
                remove_event(event,fun){
                    this.map.off(event, fun);
                    for(var place of this.places){
                        place.off(event, fun);
                        place.unbindPopup();
                    }
                    if(this.markerLayer!==null){
                        this.map.removeLayer(this.markerLayer);
                    }
                }
                fit_screen(){
                    this.map.fitBounds(this.place.getBounds());
                }
            }


            var myGeo = new EventGeo();
            myGeo.markPlace({"type":"FeatureCollection","features":[{"type":"Feature","id":"bd4c90e7-4de3-495f-901f-b235c9b593b2","geometry":{"type":"Polygon","coordinates":[[[80.18088086,9.82667697],[80.14513104,9.82539604],[80.12108116,9.8177104],[80.08013136,9.8081031],[80.04763152,9.81578896],[80.01578168,9.81578896],[79.98198185,9.80874359],[79.95403199,9.79657396],[79.94363205,9.79337135],[79.93843207,9.7831228],[79.92218215,9.77735785],[79.9124322,9.77735785],[79.89683228,9.76646823],[79.88318235,9.76198416],[79.86498244,9.7600624],[79.8136327,9.71842152],[79.78308285,9.68638655],[79.7720329,9.67485321],[79.76553294,9.66524179],[79.76488294,9.65306694],[79.76163296,9.60884928],[79.76358295,9.59218606],[79.76878292,9.58257229],[79.85068251,9.56654873],[79.85978246,9.57039445],[79.99108181,9.59667239],[80.00343175,9.60564488],[80.00668173,9.62038488],[80.00668173,9.63127925],[80.01968166,9.64794055],[80.03918157,9.64537733],[80.04633153,9.64858135],[80.06193145,9.64153245],[80.10288125,9.61397626],[80.1321311,9.60628576],[80.20038076,9.5806495],[80.2127307,9.58513599],[80.19518079,9.59218606],[80.18673083,9.64601813],[80.24718053,9.61974403],[80.29138031,9.59346788],[80.32258015,9.57488108],[80.40187975,9.63063842],[80.36417994,9.66396025],[80.31738018,9.71521816],[80.28228035,9.76838995],[80.25043051,9.82475558],[80.2133807,9.83628373],[80.18088086,9.82667697]]]},"properties":{"name":"jaffna"}}]}, 'Jaffna', 'danger', true);
            myGeo.addMarker(9.662778, 80.009127, 'place1');
            myGeo.addMarker(9.664764, 80.010809, 'place2');*/

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position)=>{
                    set_location_input(position.coords.latitude, position.coords.longitude);
                });
            } else { 
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
            
            

            
            //myGeo.draw_circle(9.662778, 80.009127,500,"marked by someone");

            function locate_current(){
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position)=>{
                        var southWest = new L.LatLng(position.coords.latitude-0.01, position.coords.longitude-0.01),
                        northEast = new L.LatLng(position.coords.latitude+0.01, position.coords.longitude+0.01),
                        bounds = new L.LatLngBounds(southWest, northEast);
                        myGeo.bound_map(bounds);
                        
                        set_location_input(position.coords.latitude, position.coords.longitude);
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

            function change_option(option){
                myGeo.fit_screen();
                var circle = document.getElementById('circle');
                var geoJson = document.getElementById('geoJson');
                switch (option){
                    case 'area':
                        geoJson.checked=true;
                        geoJson.parentElement.classList.add('active_option');
                        circle.parentElement.classList.remove('active_option');
                        break;
                    case 'circle':
                        circle.checked=true;
                        circle.parentElement.classList.add('active_option');
                        geoJson.parentElement.classList.remove('active_option');
                }
                var circle_container = document.getElementById('circle_container');
                var geoJson_container = document.getElementById('geoJson_container');

                var preview_btn = document.getElementById('preview_btn');
                if(preview_btn.classList.contains('preview')){
                    preview_btn.classList.remove('preview');
                    if(geoJson.checked){
                        show_map('area');
                        myGeo.remove_last_circle();
                    }else{
                        show_map('circle');
                        myGeo.remove_last_place();
                    }
                }

                if(circle.checked){
                    circle_container.classList.add('show_container');
                    geoJson_container.classList.remove('show_container');

                    show_map('circle');
                }else{
                    circle_container.classList.remove('show_container');
                    geoJson_container.classList.add('show_container');

                    show_map('area');
                    
                }
                
            }

            function show_map(map_inp){
                var map = document.getElementById('circle_map');
                var area_selector = document.getElementById('area_selector');

                switch (map_inp){
                    case "circle":
                        map.style.display='block';
                        area_selector.style.display='none';
                        break;
                    case 'area':
                        map.style.display='none';
                        area_selector.style.display='block';
                        break;
                }
                window.dispatchEvent(new Event('resize', { 'bubbles': true }));
                window.setTimeout(()=>{
                    myGeo.fit_screen();
                },1);
            }
            

            function submit_form(){
                if(document.getElementById('geoJson').checked){
                    editor.save(true)
                }else{
                    if(document.getElementById('lat').value!=='' && document.getElementById('lng').value!=='' && document.getElementById('rad').value!==''){
                        document.getElementById('form').firstElementChild.submit();
                    }else{
                        alert('Please fill out the form');
                    }
                }
            }
            function preview(element){
                if(element.classList.contains('preview')){
                    element.classList.remove('preview');
                    if(document.getElementById('geoJson').checked){
                        show_map('area');
                        myGeo.remove_last_place();
                    }else{
                        show_map('circle');
                        myGeo.remove_last_circle();
                    }
                }else{
                    element.classList.add('preview')
                    if(document.getElementById('geoJson').checked){
                        editor.save(false);
                        myGeo.markPlace(JSON.parse(document.getElementById('geoJson_input').value), 'suggested', 'Marked by you', true);

                        show_map('circle');
                    }else{
                        myGeo.draw_circle(document.getElementById('lat').value, document.getElementById('lng').value,parseInt(document.getElementById('rad').value), 'suggested', "marked by you", true);
                    }
                }
            }
            (document.getElementsByClassName('leaflet-control-attribution leaflet-control')[0]).style.display='none';
            for(var x of document.getElementsByClassName('ol-attribution')){
                x.style.display='none';
            };
        </script>
<?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>