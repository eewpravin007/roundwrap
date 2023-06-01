<?php
$date_current = date("Y-m-d");
?>
<ul class="navbar-nav flex-row align-items-center ms-auto">
    <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
        <a href="index.php?pagename=inoutreport&category=<?php echo $category ?>">
            <table class="dt-select-table table table-bordered" style="margin-top: 15px">
                <tr>
                    <td style="background-color: rgb(240,240,240)"><b style="color: #006699"><?php echo $wrokstation?></b></td>
                    <td><b>TOTAL IN</b></td>
                    <td>
                        <b style="color: red;font-size: 16px">
                            <?php echo $totalin = Production::getTrackingDashboardCounter($category, "IN", $date_current, $wrokstation) ?></b>
                    </td>
                    <td><b>TOTAL OUT</b></td>
                    <td><b style="color: red;font-size: 16px"><?php echo $totalout = Production::getTrackingDashboardCounter($category, "OUT", $date_current, $wrokstation) ?></b></td>
                    <td><b>BALANCE</b></td>
                    <td><b style="color: red;font-size: 16px"><?php echo $totalin - $totalout ?></b></td>
                </tr>
            </table>
        </a>
    </li>
    <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
        <a class="nav-link dropdown-toggle hide-arrow" href="#"  > 
            <i style="color:red;font-size: 14px">Welcome Touch Tracking<br/>You login at <?php echo date("Y-m-d") ?></i>
        </a>
    </li>
</ul>