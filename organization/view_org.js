
document.getElementById('event_button').addEventListener('click',function(){
    const event_button_container = document.getElementById('event_list_container');
    getEvents(event_button_container);
});
function getEvents(container){
    const request = new XMLHttpRequest();
    request.onreadystatechange=function(){
        if(this.readyState == 4 && this.status == 200){
            container.innerHTML=request.responseText;
            container.style.display='block';
        }if(this.readyState == 1){
            container.innerHTML="<div class='loader'></div>";
            container.style.display='inline-block';
        }
    }
    request.open('GET','/organization/get_events.php?events=all',true);
    request.send();
}
function view_event(event_id){
    window.location.href = 'org_view_event.php?event_id='+event_id+'&selected_org='+selected_org;
}