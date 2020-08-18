<?php require $_SERVER['DOCUMENT_ROOT']."/organization/visitor_event/visitor_event_header.php" ?>

<div id='org_event_table_caontainer'>
                <div class='org_event_head' colspan=2>
                    Event Detail
                </div>
                <div class='org_event_con'>
                    <table id=org_view_event_table>           
                        <?php
                            echo "<tr><td class='org_view_event_td'>" . ucfirst('Name') . "</td><td id=column2>" . ucfirst($result['name']) . "</td></tr>";
                            echo "<tr><td class='org_view_event_td'>" . ucfirst('Affected districts') . "</td><td id=column2>" . ucfirst($result['affected_districts']) . "</td></tr>";
                            echo "<tr><td class='org_view_event_td'>" . ucfirst('Start date') . "</td><td id=column2>" . ucfirst($result['start_date']) . "</td></tr>";
                            echo "<tr><td class='org_view_event_td'>" . ucfirst('End date') . "</td><td id=column2>" . ucfirst($result['end_date']) . "</td></tr>";
                            echo "<tr><td class='org_view_event_td'>" . ucfirst('Status') . "</td><td id=column2>" . ucfirst($result['status']) . "</td></tr>";
                            echo "<tr><td class='org_view_event_td'>" . ucfirst('Deaths and damages') . "</td><td id=column2>" . ucfirst($result['detail']) . "</td></tr>";
                        ?>
                    </table>
                </div>
            </div>