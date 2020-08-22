<?php
    require $_SERVER['DOCUMENT_ROOT']."/staff/header.php";
?>  

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

<script>
    var event_name = '<?php echo $_GET['event_id'] ?>';
</script>
<div id='map_container'>
    <div id='area_selector' style='display:block;height:500px'>
        <?php require $_SERVER['DOCUMENT_ROOT']."/common/map/maptiler-vector.html"; ?>
    </div>
</div>

<div id='form'>
    <form method='post' action='/staff/event/area/submit.php'>
        <input type='hidden' name='event_id' value='<?php echo $_GET['event_id'] ?>'>
        <input type='hidden' name='geoJson' id='geoJson_input'>

        <div id='sub_btn_container'>
            <button type='button' class='sub_btn' onclick="submit_form()">Submit</button>
            <button type='button' class='sub_btn' id='preview_btn' onclick="javascript:history.go(-1)">Cancel</button>
        </div>
    </form>  
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/staff/footer.php" ?>

<script>
    function submit_form(){
        editor.save(true)
        document.getElementById('form').firstElementChild.submit();
    }
    (document.getElementsByClassName('leaflet-control-attribution leaflet-control')[0]).style.display='none';
    for(var x of document.getElementsByClassName('ol-attribution')){
        x.style.display='none';
    };
</script>