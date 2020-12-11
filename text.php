<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<div id="load">
<button id="button">Click</button>
</div>
<script>
    $("#button").click(function(){
        $.ajax({url: "https://www.w3schools.com/jquery/tryit.asp?filename=tryjquery_ajax_load",headers: { 'User-Agent': 'Mozilla/5.0 (Linux; <Android Version>; <Build Tag etc.>) AppleWebKit/<WebKit Rev> (KHTML, like Gecko) Chrome/<Chrome Rev> Mobile Safari/<WebKit Rev>', 'Access-Control-Allow-Origin': '*', 'Origin':'www.w3schools.com'}}).done(function(data){
            $("#load").html(data);
        });
    });

    function loadDoc() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById("demo").innerHTML =
        this.responseText;
        }
    };
    xhttp.open("GET", "ajax_info.txt", true);
    xhttp.send();
    }
</script>