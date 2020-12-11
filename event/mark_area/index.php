<?php
    require $_SERVER['DOCUMENT_ROOT']."/event/event_header.php"; ?>
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