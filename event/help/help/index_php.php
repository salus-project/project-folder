<?php
    require $_SERVER['DOCUMENT_ROOT']."/confi/db_confi.php";
    require $_SERVER['DOCUMENT_ROOT']."/confi/verify.php";
 
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $event_id=$_POST['event_id'];
        $to=$_POST['to'];
        $by=$_POST['by'];
        $by_person=$_SESSION['user_nic'];
        $query_run=$query_run1=$query_run2=false;
        if(isset($_POST['cancel_button'])){
            if($by=="your_self"){
                $query2="DELETE from event_".$event_id."_pro_don WHERE by_person='".$by_person."' and to_person='".$to."'";
                $query_run2=mysqli_query($con,$query2);
            }else{
                $by_org=$by;
                $query2="DELETE from event_".$event_id."_pro_don WHERE by_org='".$by_org."' and to_person='".$to."'";
                $query_run2=mysqli_query($con,$query2);
            }
        }else{
            $things=$_POST['things'];
            $things_val=$_POST["things_val"];
            
            $note1=$_POST['note'];

            $note="";
            if($note1==NULL){
                $note="";
            }else{
                $note=$note1;
            }

            $content="";
            for($x=0 ; $x < count($things) ; $x++){
                if(!empty($things[$x])){
                    if(empty($things_val[$x])){
                            $things_val[$x]=0;
                        }
                    $content.=$things[$x].":".$things_val[$x].",";
                }
            }
            $content1=substr($content,0,-1);

            if($by=="your_self"){          
                if (isset($_POST['submit_button'])){
                    $query="INSERT INTO event_".$event_id."_pro_don (pro_don, by_person, to_person, content, note) VALUES ('promise', '$by_person', '$to', '$content1', '$note')";
                    $query_run= mysqli_query($con,$query);
                }elseif (isset($_POST['edit_button'])){
                    $query1="UPDATE `event_".$event_id."_pro_don` SET content='$content1',note='$note' where by_person='".$by_person."' and to_person='".$to."'";
                    $query_run1= mysqli_query($con,$query1);
                }
            }else{
                $by_org=$by;
                if (isset($_POST['submit_button'])){
                    $query="INSERT INTO event_".$event_id."_pro_don (pro_don, by_org, to_person, content, note) VALUES ('promise', '$by_org', '$to', '$content1', '$note')";
                    $query_run= mysqli_query($con,$query);
                }elseif (isset($_POST['edit_button'])){
                    $query1="UPDATE `event_".$event_id."_pro_don` SET content='$content1',note='$note' where by_org='".$by_org."' and to_person='".$to."'";
                    $query_run1= mysqli_query($con,$query1);
                }
            }
        }
        if($query_run || $query_run1 || $query_run2){
            header('location:/event/index.php');
        }else{
            echo '<script type="text/javascript"> alert ("Not updated") </script>';
        }
    }	
?>
