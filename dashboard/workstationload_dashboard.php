<?php
$date_for = $date_for_select = filter_input(INPUT_GET, "date_for");
if ($date_for != "") {
    $expload = explode("-", $date_for);
    $get_month = $expload[0];
    $year = $expload[1]; 
    
    $date = "-" . sprintf("%02d", $get_month) . "-";
    $date_num = sprintf("%02d", $get_month);
    $monthName = date('F', mktime(0, 0, 0, $get_month, 10)); 
} else {
    $date = date("-m-");
    $year = date("Y");
    $date_num = date("m");
    $monthName = date('F', mktime(0, 0, 0, $date_num, 10));
}

$workStationLoad = MainPageStatestic::workStationLoad($date, $year);

//FOR PVC
$showLoad_CNC = MainPageStatestic::showLoad($workStationLoad, "CNC");
$showLoad_SANDCLEAN = MainPageStatestic::showLoad($workStationLoad, "SAND/CLEAN");
$showLoad_GLUE = MainPageStatestic::showLoad($workStationLoad, "GLUE");
$showLoad_VINYLPRESS = MainPageStatestic::showLoad($workStationLoad, "VINYL PRESS AND PACK");

//FOR LAMINATE
$showLoad_LAMINATEPRESS = MainPageStatestic::showLoad($workStationLoad, "LAMINATE PRESS");
$showLoad_SAWDOOR = MainPageStatestic::showLoad($workStationLoad, "SAW/DOOR");
$showLoad_EDGEBANDING = MainPageStatestic::showLoad($workStationLoad, "EDGE BANDING");
$showLoad_LAMINATECLEANPACK = MainPageStatestic::showLoad($workStationLoad, "LAMINATE CLEAN/PACK");
?>

<input type="hidden" id="cnc_date" value="<?php echo $showLoad_CNC[0] ?>">
<input type="hidden" id="cnc_value" value="<?php echo $showLoad_CNC[1] ?>">

<input type="hidden" id="sandclean_date" value="<?php echo $showLoad_SANDCLEAN[0] ?>">
<input type="hidden" id="sandclean_value" value="<?php echo $showLoad_SANDCLEAN[1] ?>">

<input type="hidden" id="glue_date" value="<?php echo $showLoad_GLUE[0] ?>">
<input type="hidden" id="glue_value" value="<?php echo $showLoad_GLUE[1] ?>">

<input type="hidden" id="vinylpress_date" value="<?php echo $showLoad_VINYLPRESS[0] ?>">
<input type="hidden" id="vinylpress_value" value="<?php echo $showLoad_VINYLPRESS[1] ?>">

<input type="hidden" id="laminatepress_date" value="<?php echo $showLoad_LAMINATEPRESS[0] ?>">
<input type="hidden" id="laminatepress_value" value="<?php echo $showLoad_LAMINATEPRESS[1] ?>">

<input type="hidden" id="sawdoor_date" value="<?php echo $showLoad_SAWDOOR[0] ?>">
<input type="hidden" id="sawdoor_value" value="<?php echo $showLoad_SAWDOOR[1] ?>">

<input type="hidden" id="edgebanding_date" value="<?php echo $showLoad_EDGEBANDING[0] ?>">
<input type="hidden" id="edgebanding_value" value="<?php echo $showLoad_EDGEBANDING[1] ?>">

<input type="hidden" id="laminatecleanpack_date" value="<?php echo $showLoad_LAMINATECLEANPACK[0] ?>">
<input type="hidden" id="laminatecleanpack_value" value="<?php echo $showLoad_LAMINATECLEANPACK[1] ?>">

<style>
    .dt-fixedcolumns thead{
        background-color: rgb(220,220,220);
    }
</style>

<div class="card mb-12">
    <h5 class="card-header">This is your weekly station report and load on station.</h5>
    <form class="card-body" method="POST">
        <?php
        $date_num_c = date("m");
        for ($index = 0; $index < 6; $index++) {
            $monthName_c = date('F', mktime(0, 0, 0, ($date_num_c - $index), 10));
            $month_year = date('m-Y', strtotime("-$index month"));
            ?>
            <a 
                style="margin-right: 10px;"
                href="index.php?pagename=workstationload_dashboard&date_for=<?php echo $month_year ?>" 
                class="btn btn-label-secondary <?php echo $date_for_select == $month_year ? "active" : "" ?>">
                    <?php echo $monthName_c ?>
            </a>
            <?php
        }
        ?>
        <a href="index.php?pagename=workstationloadtable_dashboard"
           class="btn btn-label-secondary" style="float: right;margin-left: 10px">
            <i class="bx bx-table"></i>
            TABLE VIEW
        </a>
    </form>
</div> 
<br/>
<div class="row">
    <div class="col-lg-12 col-md-12 mb-12">
        <!-- Heat map Chart -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">PVC Station Monthly Performance Chart - <?php echo $monthName ?></h5>
            </div>
            <div class="card-body">
                <div id="pvcHeatMapChart"></div>
            </div>
        </div>
    </div>
</div>
<!-- /Heat map Chart -->
<br/>
<div class="row">

    <div class="col-lg-12 col-md-12 mb-12">
        <!-- Heat map Chart -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Laminate Stations Monthly Performance Chart - <?php echo $monthName ?></h5>
            </div>
            <div class="card-body">
                <div id="lmiHeatMapChart"></div>
            </div>
        </div>
    </div>
</div>

