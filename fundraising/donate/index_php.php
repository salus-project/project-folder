<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
 
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $id=$_POST['id'];
        $by=$_POST['by'];
        $by_person=$_SESSION['user_nic'];
        if(isset($_POST['pro_cancel_button'])){
            if($by=="your_self"){
                $query2="DELETE from fundraising_pro_don WHERE by_person='".$by_person."' and for_fund='".$id."'";
                $query_run2=mysqli_query($con,$query2);
            }else{
                $by_org=$by;
                $query2="DELETE from fundraising_pro_don WHERE by_org='".$by_org."' and for_fund='".$id."'";
                $query_run2=mysqli_query($con,$query2);
            }
        }else{
           
            $donation_quan=$_POST["donation"];
            $note1=$_POST['note'];
            $note="";
            if($note1==NULL){
                $note="";
            }else{
                $note=$note1;
            }
            $by_person=$_SESSION['user_nic'];

            $query="select * from fundraisings where id=".$id;
            $result=($con->query($query))->fetch_assoc();

            $content="";
            if($result['type']=="money only"){
                if(empty($donation_quan[0])){
                    $donation_quan[0]=0;
                }
                $content.="money:".$donation_quan[0].",";
                
            }elseif($result['type']=="things only"){
                $things=explode(",",$result['expecting_things']);
                for($x=0 ; $x < count($things) ; $x++){
                    if(empty($donation_quan[$x])){
                        $donation_quan[$x]=0;
                    }
                    $content.=(explode(":",$things[$x]))[0].":".$donation_quan[$x].",";
                }
            }else{
                if(empty($donation_quan[0])){
                    $donation_quan[0]=0;
                }
                $content.="money:".$donation_quan[0].",";
                $things=explode(",",$result['expecting_things']);
                for($x=0 ; $x < count($things) ; $x++){
                    if(empty($donation_quan[$x+1])){
                        $donation_quan[$x+1]=0;
                    }
                    $content.=(explode(":",$things[$x]))[0].":".$donation_quan[$x+1].",";
                }
                
            }

            $content1=substr($content,0,-1);
            $query_run=$query_run1=false;
            if($by=="your_self"){          
                if (isset($_POST['pro_submit_button'])){
                    $query="INSERT INTO fundraising_pro_don (pro_don, by_person, for_fund, content, note) VALUES ('promise', '$by_person', '$id', '$content1', '$note')";
                    $query_run= mysqli_query($con,$query);
                }elseif(isset($_POST['pro_edit_button'])){
                    $query1="UPDATE `fundraising_pro_don` SET content='$content1',note='$note' where by_person='".$by_person."' and for_fund='".$id."'";
                    $query_run1= mysqli_query($con,$query1);       
                }
            }else{
                $by_org=$by;
                if (isset($_POST['pro_submit_button'])){
                    $query="INSERT INTO fundraising_pro_don (pro_don, by_org, for_fund, content, note) VALUES ('promise', '$by_org', '$id', '$content1', '$note')";
                    $query_run= mysqli_query($con,$query);
                }elseif(isset($_POST['pro_edit_button'])){
                    $query1="UPDATE `fundraising_pro_don` SET content='$content1',note='$note' where by_org='".$by_org."' and for_fund='".$id."'";
                    $query_run1= mysqli_query($con,$query1);       
                }
            }
        }
        if($query_run || $query_run1 || $query_run2){
            header('location:/fundraising/index.php');
        }else{
            echo '<script type="text/javascript"> alert ("Not donated") </script>';
        }
    }	
?>