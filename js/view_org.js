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
    window.location.href = link+'?event_id='+event_id+'&selected_org='+selected_org;
}

function confirmFn() {
    swal({
        title: "Are you sure?",
        text: "Once you leave, you can join only as a member!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
        if (willDelete) {
                document.getElementById("org_leave_form").submit();
            } 
    });
}
function delOrgFn(orgId) {
    swal({
        title: "Are you sure?",
        text: "Once you deleted, you can not recover it!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
        if (willDelete) {
            window.location.href = '/organization/del_org.php?org_id='+orgId;
            } 
    });
}

    
