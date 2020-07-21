<div id="show_nav">
  <button class="show_button show_nav show_xlarge" onclick="side_nav_open(this)">☰</button>
</div>
<div id='side_nav_container'>
    <div id='close'>
        <button class="show_button show_nav show_xlarge" onclick="side_nav_close(this)">CLOSE</button>

    </div>
    <div id="other_mem_header">
        Other Members
    </div>
    <table id="side_nav_table">
        <h2>Temporarily unavailable</h2>
    </table>
</div>
<script>
    /*setInterval(get_last_seen,5000);
    const side_nav_table = document.getElementById('side_nav_table');
    function get_last_seen(){
        const request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                side_nav_table.innerHTML=request.responseText;
            }
        }
        request.open('GET','/includes/get_side_nav.php',true);
        request.send();
    }*/
    function side_nav_open(element) {
        document.getElementById("side_nav_container").style.display = "inline-table";
        document.getElementById("show_nav").style.display="none";
    }

    function side_nav_close(element) {
        document.getElementById("side_nav_container").style.display = "none";
        document.getElementById("show_nav").style.display="block";
    }
</script>