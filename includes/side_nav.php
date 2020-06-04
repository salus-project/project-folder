<div id='side_nav_container'>
    <div id="other_mem_header">
        Other Members
    </div>
    <table id="side_nav_table">
        <?php
            $civilian_query = "select first_name, last_name, NIC_num from civilian_detail";
            $civilian = $con->query($civilian_query);
            while($row=$civilian->fetch_assoc()){
                echo "<tr><td>".$row['first_name']." ".$row['last_name']."</td></tr>";
            }
        ?>
    </table>
</div>