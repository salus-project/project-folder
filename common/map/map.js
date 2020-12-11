
/*
-
-
-
-
-
-
-
-
-*/
/*my map js*/



class MarkerIcon{
    constructor(){
        this.marker = L.icon({
            iconUrl:'/common/markers/marker1.png',
            iconSize:[38,40],
            iconAnchor:[19,40]
        });
    }
    create_icon(type){
        switch(type){
            case 'requested':
                this.marker.options.iconUrl = '/common/markers/requested.png';
                break;
            case 'suggested':
                this.marker.options.iconUrl = '/common/markers/suggested.png';
                break;
            case 'home':
                this.marker.options.iconUrl = '/common/markers/home.png';
                break;
            case 'donation':
                this.marker.options.iconUrl = '/common/markers/donation.png';
                break;
            case 'medical':
                this.marker.options.iconUrl = '/common/markers/medical.png';
                break;
            case 'custom':
                this.marker.options.iconUrl = '/common/markers/marker1.png';
                break;
            default:
                this.marker.options.iconUrl = '/common/markers/marker1.png';
        }
        return this.marker;
    }
}
class AreaStyle{
    constructor(){
        
    }
    create(area){
        switch (area) {
            case 'danger':
                this.fillColor='red';
                this.color='red';
                this.weight = 4;
                this.opacity = 0.3;
                this.fillOpacity = 0.08;
                break;
            case 'suggested':
                this.fillColor='orange';
                this.color='orange';
                this.weight = 0.1;
                this.opacity = 0.3;
                this.fillOpacity = 0.3;
                break;
            case 'relief':
                this.fillColor='#51c2f1';
                this.color='#2196F3';
                this.weight = 2.5;
                this.opacity = 0.3;
                this.fillOpacity = 0.3;
                break;
            case 'rescue':
                this.fillColor='#86d42b';
                this.color='green';
                this.weight = 2.5;
                this.opacity = 0.3;
                this.fillOpacity = 0.25;
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
    constructor(id='map', x=6.9,y=80,zoom=12){
        var container = document.getElementById(id);
        container.style.zIndex=1;
        this.map = L.map(id).setView([x, y],zoom);
        L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=fN8T3G0qqLvrBTjTZJfJ'/*, {
            attribution:'<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
            
        }*/).addTo(this.map);

    
        this.markerIcon = new MarkerIcon();
        this.areaObj = new AreaStyle();
        this.markerLayer=null;
        this.markers = [];
        this.places = [];
        this.circles = [];
        this.last_place_circle = null;

        if (navigator.geolocation) {
            var obj=this;
            navigator.geolocation.getCurrentPosition((position)=>{
                obj.addMarker(position.coords.latitude, position.coords.longitude, 'home', 'your are here');
            });
        } else { 
            alert("Geolocation is not supported by this browser.");
        }

        container.addEventListener('resize', function(){
            this.map.invalidateSize();
        });
    }
    addMarker(x,y,icon_txt,msg){
        this.marker = L.marker([x, y],{icon:this.markerIcon.create_icon(icon_txt), draggable:false}).addTo(this.map);
        this.marker.bindPopup(msg);
        this.markers.push(this.marker);
    }
    remove_last_marker(){
        this.markers.pop().remove();
        this.marker = this.markers[this.markers.length-1];
    }
    addMarkerLayer(xy,icon_txt='',msg=''){
        if(this.markerLayer!==null){
            this.map.removeLayer(this.markerLayer);
        }
        this.markerLayer = L.marker(xy,{icon:this.markerIcon.create_icon(icon_txt), draggable:false});
        this.map.addLayer(this.markerLayer);
        if(msg!==''){
            this.markerLayer.bindPopup(msg);
        }
    }
    markPlace(geoJson, area, msg, center=false){
        this.place = L.geoJSON(geoJson,{
            style: this.areaObj.create(area)
        }).addTo(this.map);
        this.place.bindPopup(msg);
        if(center){
            try{
                this.map.fitBounds(this.place.getBounds());
            }catch(err){} 
        }
        this.last_place_circle=this.place;
        this.places.push(this.place);
    }

    remove_last_place(){
        this.places.pop().remove();
        this.place = this.places[this.places.length-1];
    }

    draw_circle(x, y, rad, area, msg, center=false){
        var style = this.areaObj.create(area);
        style.radius=parseInt(rad);
        this.circle = L.circle([x, y], style).addTo(this.map);
        this.circle.bindPopup(msg);
        if(center){
            this.map.fitBounds(this.circle.getBounds());
        }
        this.last_place_circle=this.circle;
        this.circles.push(this.circle);
    }

    remove_last_circle(){
        this.circles.pop().remove();
        this.circle = this.circles[this.circles.length-1]
    }

    remove_last_place_circle(){
        if(this.last_place_circle!==null){
            this.last_place_circle.remove();
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
        this.map.invalidateSize();
        try{
            this.map.fitBounds(this.place.getBounds());
        }catch(err){} 
    }
    create_place(arr,cent=false){
        switch(arr['type']){
            case 'suggested_circle':
                this.draw_circle(arr['latitude'], arr['longitude'],arr['radius'], 'suggested', arr['detail'], cent);
                break;
            case 'suggested_area':
                this.markPlace(JSON.parse(arr['geojson']), 'suggested', arr['detail'], cent);
                break;
            case 'relief_circle':
                this.draw_circle(arr['latitude'], arr['longitude'],arr['radius'], 'relief', arr['detail'], cent);
                break;
            case 'relief_area':
                this.markPlace(JSON.parse(arr['geojson']), 'relief', arr['detail'], cent);
                break;
            case 'rescue_circle':
                this.draw_circle(arr['latitude'], arr['longitude'],arr['radius'], 'rescue', arr['detail'], cent);
                break;
            case 'rescue_area':
                this.markPlace(JSON.parse(arr['geojson']), 'rescue', arr['detail'], cent);
                break;
            case 'medical':
            case 'donation':
            case 'other':
                myGeo.addMarker(arr['latitude'], arr['longitude'], arr['type'], arr['detail'], cent);
                break;
            default:
                console.log('error');
            
        }
    }
}

function create_place(arr,cent=false){
    switch(arr['type']){
        case 'suggested_circle':
            myGeo.draw_circle(arr['latitude'], arr['longitude'],arr['radius'], 'suggested', arr['detail'], cent);
            break;
        case 'suggested_area':
            myGeo.markPlace(JSON.parse(arr['geojson']), 'suggested', arr['detail'], cent);
            break;
        case 'relief_circle':
            myGeo.draw_circle(arr['latitude'], arr['longitude'],arr['radius'], 'relief', arr['detail'], cent);
            break;
        case 'relief_area':
            myGeo.markPlace(JSON.parse(arr['geojson']), 'relief', arr['detail'], cent);
            break;
        case 'rescue_circle':
            myGeo.draw_circle(arr['latitude'], arr['longitude'],arr['radius'], 'rescue', arr['detail'], cent);
            break;
        case 'rescue_area':
            myGeo.markPlace(JSON.parse(arr['geojson']), 'rescue', arr['detail'], cent);
            break;
        case 'medical':
        case 'donation':
        case 'other':
            myGeo.addMarker(arr['latitude'], arr['longitude'], arr['type'], arr['detail'], cent);
            break;
        default:
            console.log('error');
        
    }
}

/*var myGeo = new EventGeo();
myGeo.markPlace(areaGeoJson, 'danger', 'Affected area',  true);

for(var place of location_arr){
    create_place(place);
}*/

/*if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition((position)=>{
        myGeo.addMarker(position.coords.latitude, position.coords.longitude, 'home', 'your are here');
    });
} else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
}*/

function inside(point, geoJson) {
    var vs = geoJson.features[0].geometry.coordinates[0].slice(0, -1);;
    point = [point['lng'],point['lat']];

    var x = point[0], y = point[1];

    var inside = false;
    for (var i = 0, j = vs.length - 1; i < vs.length; j = i++) {
        var xi = vs[i][0], yi = vs[i][1];
        var xj = vs[j][0], yj = vs[j][1];

        var intersect = ((yi > y) != (yj > y))
            && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
        if (intersect) inside = !inside;
    }
    return inside;
}

document.addEventListener("DOMContentLoaded", function(event){
    (document.getElementsByClassName('leaflet-control-attribution leaflet-control')[0]).style.display='none';
});


/*
-
-
-
-
-
-
-
-
-
-
-
-
-
*/