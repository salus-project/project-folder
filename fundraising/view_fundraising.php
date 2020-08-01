<?php 
require $_SERVER['DOCUMENT_ROOT']."/includes/header.php";
$query="select * from fundraisings where id=".$_GET['view_fun'].";
    select * from civilian_detail where NIC_num=(
        select by_civilian from fundraisings where id=".$_GET['view_fun']."
    );
    select org_name from organizations where org_id=(
        select by_org from fundraisings where id=".$_GET['view_fun']."); 
    select name from disaster_events where event_id=(
        select for_event from fundraisings where id=".$_GET['view_fun'].");
    select * from fundraisings_expects where fund_id=".$_GET['view_fun'].";
    select * from fundraising_pro_don left join civilian_detail on civilian_detail.NIC_num = fundraising_pro_don.by_person left join organizations on organizations.org_id = fundraising_pro_don.by_org where for_fund=".$_GET['view_fun'].";
    select * from  fundraising_pro_don inner join fundraising_pro_don_content on fundraising_pro_don.id = fundraising_pro_don_content.don_id where for_fund=".$_GET['view_fun'].";
    select fundraisings.name,public_posts.* from fundraisings inner join public_posts on fundraisings.id=public_posts.fund where fundraisings.id=".$_GET['view_fun'].";";

    if(mysqli_multi_query($con,$query)){
        $result = mysqli_store_result($con);
        $fundraising = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $civi_detail = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $org_name_result=mysqli_fetch_assoc($result);
        $org_name_fundraising = (isset($org_name_result['org_name']))?$org_name_result['org_name']:'';
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $event_name_result=mysqli_fetch_assoc($result);
        $event_name_fundraising = (isset($event_name_result['name']))?$event_name_result['name']:'';
        mysqli_free_result($result);

           
        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $fund_expect = mysqli_fetch_all($result,MYSQLI_ASSOC);
        mysqli_free_result($result);
        $expect="";
        foreach($fund_expect as $row_req){
            $expect.=$row_req['item']." : ".$row_req['amount']."<br>";
        }

        $person_org_detail=[];
        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $person_org_detail = mysqli_fetch_all($result,MYSQLI_ASSOC);
        mysqli_free_result($result);

        $content_detail=[];
        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $content_detail = mysqli_fetch_all($result,MYSQLI_ASSOC);
        mysqli_free_result($result);

        mysqli_next_result($con);
        $result = mysqli_store_result($con);
        $fund_post=mysqli_fetch_all($result,MYSQLI_ASSOC);
        mysqli_free_result($result);
       
    }
?>

        <title>view fundraising event</title>
        <link rel="stylesheet" href='/css_codes/view_fundraising.css'>
        <link rel="stylesheet" href='/css_codes/publ.css'>
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <script src="https://kit.fontawesome.com/b17fa3a18c.js" crossorigin="anonymous"></script>
        <script src="/common/post/post.js"></script>
        <link href="/css_codes/bootstrap-toggle.css" rel="stylesheet">
        <link rel="stylesheet" href='/css_codes/view_my_event_individual_promise.css'>


        <script>
            btnPress(7);
        </script>
        <div class='main_slide_show'>	
            <div class="slideshow-container">

                <div class="mySlides fade">
                <img class='slide_show_img' src="/fundraising/images/1127259.jpg" style="width:100%">
                <div class="text">Caption Text</div>
                </div>

                <div class="mySlides fade">
                <img class='slide_show_img' src="/fundraising/images/228396562.jpg" style="width:100%">
                <div class="text">Caption Two</div>
                </div>

                <div class="mySlides fade">
                <img class='slide_show_img' src="/fundraising/images/e8c7c4d4e14a9e3b21faf3d7b37c5b03.jpg" style="width:100%">
                <div class="text">Caption Three</div>
                </div>

                <div class="mySlides fade">
                    <img class='slide_show_img' src="/fundraising/images/Fabulous scenery.jpg" style="width:100%">
                    <div class="text">Caption four</div>
                </div>
                <div class='dot_div' style="text-align:center">
                    <span class="dot"></span> 
                    <span class="dot"></span> 
                    <span class="dot"></span> 
                    <span class="dot"></span> 
                </div>
            </div>
        </div>
        	
	<script>
		var slideshow = document.getElementsByClassName("slideshow-container"); // Do not use a period here!
		var j;
		for (j = 0; j < slideshow.length; j++) {
			al_show_slide(slideshow[j]);
		}	
		function al_show_slide(element){	
			var slideIndex = 0;	
			function showSlides() {			
				var i;
				var slides = element.getElementsByClassName("mySlides");
				var dots = slideshow[0].getElementsByClassName("dot");
				for (i = 0; i < slides.length; i++) {
					slides[i].style.display = "none";  
				}
				slideIndex++;
				if (slideIndex > slides.length) {slideIndex = 1}    
				for (i = 0; i < dots.length; i++) {
					dots[i].className = dots[i].className.replace(" active", "");
				}
				slides[slideIndex-1].style.display = "block";  
				dots[slideIndex-1].className += " active";
				setTimeout(showSlides, 5000);
			}			
			showSlides();
		}
	</script>
        <div id="title">
            <?php echo '<center>'.$fundraising['name'].'</center>' ?>
        </div>
        <div id='fund_body'>
            <?php
                if($fundraising['by_civilian']==$_SESSION['user_nic']){
                    echo "<div id=fund_edit_btn_container >";
                    echo "<a href='/fundraising/edit_fundraising.php?edit_btn=".$_GET['view_fun']."'>";
                    echo "<button id='edit_btn' >Edit</button>";
                    echo "</a>";
                    echo"</div>";

                    echo "<div id=img_edit_btn_container >";
                    echo "<a href='/fundraising/edit_fundraising_img.php?id=".$_GET['view_fun']."'>";
                    echo "<button id='edit_img_btn' >Edit Images</button>";
                    echo "</a>";
                    echo"</div>";
                }
            ?>

            <table id='fund_table'>
                <?php
                    echo '<tr><td id=column1> Created by </td><td id=column2>' . $civi_detail['first_name'] ." ". $civi_detail['last_name']. '</td></tr>';


                if($fundraising['by_org']!=NULL){
                    echo '<tr><td id=column1> Org name</td><td id=column2>' . $org_name_fundraising . '</td></tr>';
                }
                if($fundraising['for_event']==NULL){
                    echo '<tr><td id=column1> Purpose</td><td id=column2>' . $fundraising['for_any'] . '</td></tr>';
                }else{
                    echo '<tr><td id=column1>Purpose</td><td id=column2>' . $event_name_fundraising . '</td></tr>';
                }
                    echo '<tr><td id=column1> Expectations </td><td id=column2>' . $expect . '</td></tr>';

                ?>

                <tr>
                    <td>Service area </td>
                    <td><?php echo $fundraising['service_area'] ?></td>
                </tr>
                <tr>
                    <td>description </td>
                    <td><?php echo $fundraising['description'] ?></td>
                </tr>

            </table>
        </div>

        <div class='promise_body'>
        <div class="promise_table_body">
            <table class='promise_table'>
                <tr class="first_head">
                    <th colspan=4>Promises</th>
                </tr>
                <tr class="second_head">
                    <th colspan=1>Full name </th>   
                    <th colspan=1>Promises</th>
                    <th colspan=1>Status</th>
                    <th colspan=1>Note</th>
                </tr>
                <?php
                    foreach($person_org_detail as $row_req){
                        if ($row_req['org_name']==""){
                            $name=$row_req['first_name']." ".$row_req['last_name'];
                            $by=$row_req['NIC_num'];
                        }
                        else{
                            $name=$row_req['org_name'];
                            $by=$row_req['org_id'];
                        }
                        $note=$row_req['note'];
                        $promise_array=[];
                        $pending_array=[];
                        $full_array=[];
                        $id_arr=[];
                        foreach($content_detail as $row_req1){
                            if ($row_req1['don_id']==$row_req['id']){
                                $item_amount=$row_req1['item'].":".$row_req1['amount'];
                                if (($row_req1['pro_don']=="promise") && ($row_req1['pro_don']=="pending")){
                                    array_push($promise_array,$item_amount);
                                }else if ($row_req1['pro_don']=="helped"){
                                    array_push($pending_array,$item_amount);
                                }
                                array_push($full_array,$item_amount);
                                array_push($id_arr,$row_req1['id']);
                            }
                        }
                        for($x=0; $x < count($full_array); $x++ ){
                            $value=$full_array[$x];
                            if(in_array($value,$pending_array)){
                                $checked="checked='checked'";
                                $text_status="pending";
                            }
                            else{
                                $checked="";
                                $text_status="promise";
                            }
                            if ($x==0){
                                $name_data_row="<td rowspan=".count($full_array).">".$name."</td>";
                                $note_data_row="<td rowspan=".count($full_array).">".$note."</td>";
                            }
                            else{
                                $name_data_row=$note_data_row="";
                            }
                            if($fundraising['by_civilian']==$_SESSION['user_nic']){
                         echo "  <tr>
                            ".$name_data_row."
                            <td>".$value."</td>
                            <td class='not_click'>
                            <input type='checkbox'".$checked."data-toggle='toggle' data-on='Helped' data-off='Not helped' data-width='100' data-height='15' data-offstyle='warning' data-onstyle='success' onchange='toggleFn(this,".$id_arr[$x].")'>
                            </td>
                            ".$note_data_row."
                        </tr>";
                        }else{
                            echo "  <tr>
                            ".$name_data_row."
                            <td>".$value."</td>
                            <td >".$text_status."</td>
                            ".$note_data_row."
                        </tr>";
                        }
                        }
                    }    
                ?>
            </table>
        </div>
        </div>
        <div class='promise_body'>
        <div class="promise_table_body">
            <table class='promise_table'>
                <tr class="first_head">
                    <th colspan=4> Donations </th>
                </tr>
                <tr class="second_head">
                    <th colspan=1>Full name </th>   
                    <th colspan=1>Donations</th>
                    <th colspan=1>Note</th>
                </tr>
                <?php
                    foreach($person_org_detail as $row_req){
                        if ($row_req['org_name']==""){
                            $name=$row_req['first_name']." ".$row_req['last_name'];
                            $by=$row_req['NIC_num'];
                        }
                        else{
                            $name=$row_req['org_name'];
                            $by=$row_req['org_id'];
                        }
                        $item_amount="";
                        $note=$row_req['note'];
                        foreach($content_detail as $row_req1){
                            if ($row_req1['don_id']==$row_req['id']){
                                if ($row_req1['pro_don']=="donated"){
                                $item_amount=$item_amount.$row_req1['item'].":".$row_req1['amount']."<br>";
                            }
                            }
                        }
                        if ($item_amount!=""){
                        echo "  <td>".$name."</td><td>".$item_amount."</td>
                                    <td>".$note."</td>
                                </tr>";}
                    }   
                ?>
            </table>
        </div>
        </div>
        <div id='fund_post_div'>
            <div id="post_title">
                <?php echo "OUR POSTS" ?>
            </div>           
            <div id="content">

            </div>
        </div>
        <script>
            var post = new Post("select fundraisings.name,public_posts.* from fundraisings inner join public_posts on fundraisings.id=public_posts.fund where fundraisings.id="+<?php echo $_GET['view_fun'] ?>);
            post.get_post();

            function toggleFn(ele,id){
                if (ele.checked){
                var c_status='helped';
                }else{
                var c_status='pending';
                }
                var sql="UPDATE `fundraising_pro_don_content` SET `pro_don` = '"+c_status+"' WHERE `id` = "+id+"";;
                var xhttp = new XMLHttpRequest();
                // xhttp.onreadystatechange = function() {
                //     if (this.readyState == 4 && this.status == 200) {
                //         console.log(this.responseText);
                //     }
                //  };
                xhttp.open("POST", "/common/postajax/post_ajax.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("sql="+sql);
            }
        </script>     
        <?php include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php" ?>