<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>


<?php
$filter_input_get = filter_input(INPUT_GET, "templateid");
if ($filter_input_get == "") {
    $today = time();
    $wday = date('w', $today);
    $mday = date('m', $today);
    $weekkey = $wday . "" . $mday;
    $dates = array();
    $dates[] = $datemon = date('Y-m-d', $today - ($wday - 1) * 86400);
    $dates[] = $datetue = date('Y-m-d', $today - ($wday - 2) * 86400);
    $dates[] = $datewed = date('Y-m-d', $today - ($wday - 3) * 86400);
    $dates[] = $datethu = date('Y-m-d', $today - ($wday - 4) * 86400);
    $dates[] = $datefri = date('Y-m-d', $today - ($wday - 5) * 86400);
    $dates[] = $datesat = date('Y-m-d', $today - ($wday - 6) * 86400);
} else {
    $data = array();
    $result = Operatios::listWeeklyAgendaTemplate($filter_input_get);
    $dates = array();
    $dates_data = array();
    foreach ($result as $value) {
        $dates[] = $value["startDate"];
        $dates_data[$value["startDate"]] = $value["reminderbody"];
    }
}
$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnCreate"] == "Create Agenda") {
    unset($filter_input_array["btnCreate"]);
    $dates = $filter_input_array["dates"];
    $description = $filter_input_array["description"];
    MysqlConnection::delete("DELETE FROM tbl_weekly_agenda WHERE weeknumber = '$filter_input_get'  ");
    for ($index = 0; $index <= count($description); $index++) {
        $data = array();
        $data["startDate"] = $dates[$index];
        $data["weeknumber"] = $weekkey;
        $data["remindertline"] = $description[$index];
        $data["reminderbody"] = $description[$index];

        Operatios::createWeeklyAgendaTemplate("", $data);
        header("location:index.php?pagename=weeklyagenda_operations");
    }
}
?>
<form id="formAccountSettings" method="POST" enctype="multipart/form-data">
    <div class="card mb-4">
        <h5 class="card-header" style="color: red"><i class="bx bx-globe"></i>Create your weekly agenda</h5>
        <div class="card-body">
            <table  class="table table-bordered dt-select-table" >
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Date</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($dates as $value) {
                        ?>
                        <tr style="vertical-align: middle">
                            <td style="width: 120px">
                                <?php echo $value ?>
                            </td>
                            <td style="width: 120px">
                                <?php echo date('l', strtotime($value)); ?>
                                <input type="hidden"  class="form-control"  name="dates[]" value="<?php echo $value ?>">
                            </td>
                            <td>
                                <input type="text"  class="form-control"  name="description[]" value="<?php echo $dates_data[$value] ?>">
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="mt-2">
                <input  type="submit" name="btnCreate" class="btn btn-primary me-2" value="Create Agenda">
                <a  href="index.php?pagename=weeklyagenda_operations" class="btn btn-label-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>