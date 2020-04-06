<?php
    session_start();
    require 'dbconfi/confi.php';
    require 'header.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Update Help</title>
        <link rel="stylesheet" href="css_codes/style.css">
    </head>

    <body style="background-color: #dedede">

    <script> btnPress(4) </script>
        <center>
            <h1> Update my Help </h1>

            <div class="div1">
            <form  class="form_box" action="helpothers.php" method="POST">

                <label class="label"  style="font-weight:bolder;">Type </label><br>
                    from home<input type="checkbox" name="type[]"  value="from_home"><br/>
                    on the spot<input type="checkbox" name="type[]"  value="on_the_spot"><br/><br/>

                <label class="label"  style="font-weight:bolder;">Money or Goods </label><br>

                <input type="checkbox" name="money_or_goods" value="money"  onclick="OnChangeCheckbox (this,'amount')"id ="money"/>Money
                <input type="textbox" id="amount" style="display:none"/>
                <br/>

                <input type="checkbox" name="money_or_goods" value="goods"  onclick="OnChangeCheckbox (this,'things')" id="goods"/>Goods
                <input type="textbox" id="things" style="display:none"/>
                <br/>
                <br/>

                <input name="update_button" type="submit"  value="Submit"  class="login_button"><br>   

                <script>
                    function OnChangeCheckbox (checkbox,text_box) {
                        if (checkbox.checked) {
                            document.getElementById(text_box).style.display="block"; 
                        }
                        else {
                            document.getElementById(text_box).style.display="none"; 
                        }
                    }
                </script>

            </form>


            </div>
        <center>
    </body>
</html>