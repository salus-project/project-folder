<div id='side_nav_container' class='side_nav_container <?php echo (($_SESSION['side_nav']=='1')?'show_side_nav':''); ?>'>
    <div id="other_mem_header">
        Other Members
    </div>
    <table id="side_nav_table">
    </table>
</div>
<script>
    /*setInterval(get_last_seen,5000);*/
    const side_nav_table = document.getElementById('side_nav_table');
    get_last_seen();
    function get_last_seen(){
        const request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                side_nav_table.innerHTML=request.responseText;
            }
        }
        request.open('GET','/includes/get_side_nav.php',true);
        request.send();
    }
    function side_nav_open(element) {
        document.getElementById("side_nav_container").style.display = "inline-table";
        document.getElementById("show_nav").style.display="none";
    }
    function side_nav_close(element) {
        document.getElementById("side_nav_container").style.display = "none";
        document.getElementById("show_nav").style.display="block";
    }
    /*function toggle_side_nav(){
        document.getElementById("side_nav_container").classList.toggle('show_side_nav');
    }*/
    $('#dropdown_toggle_checkbox').change(function(){
        $('#side_nav_container').toggleClass('show_side_nav');
        $('#sub_body').toggleClass('full_sub_body');
        $('#main_footer').toggleClass('full_footer');
        if($('#dropdown_toggle_checkbox').prop('checked')){
            var side = 1;
        }else{
            var side = 0;
        }
        $.post("/includes/set_sidenav_ajax.php",{
            side_nav: side
        });
    })
</script>