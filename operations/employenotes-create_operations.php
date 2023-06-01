<?php
$templateid = filter_input(INPUT_GET, "templateid");
if ($templateid != "") {
    $template = Operatios::listEmployeeNoteTemplate($templateid);
}
$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnCreate"] == "Create Work Station Note") {
    unset($filter_input_array["btnCreate"]);
    $explaod = explode("_", $filter_input_array["userdetails"]);
    $filter_input_array["empid"] = $explaod[0];
    $filter_input_array["empname"] = $explaod[1];
    unset($filter_input_array["userdetails"]);
    Operatios::createEmployeeNoteTemplate($templateid, $filter_input_array);
    header("location:index.php?pagename=employenotes_operations");
}

$dropdownuser = array();
$dropdownuser["danger"] = "Very Urgent";
$dropdownuser["warning"] = "Urgent";
$dropdownuser["success"] = "Normal";
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">Create Work Station Note</h5>
    <div class="card-body">
        <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="remindertline" class="form-label">Process mode of work order</label>
                    <select class="form-control" name="userdetails" >
                        <?php
                        foreach ($dropdownuser as $key => $value) {
                            $selected = $key == $template["empid"] ? "selected" : "";
                            ?>
                            <option <?php echo $selected ?> value="<?php echo $key . "_" . $value ?>"><?php echo $value ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="reminderbody" class="form-label">Work station Description</label>
                    <textarea required="" class="form-control" type="text" id="reminderbody" name="reminderbody" 
                              style="height: 180px;resize: none"><?php echo $template["reminderbody"] ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="startDate" class="form-label">Need by Date?</label>
                    <input required="" type="text" class="form-control date-picker flatpickr-input active" 
                           value="<?php echo $template["startDate"] == "" ? date("Y-m-d") : $template["startDate"] ?>"
                           placeholder="YYYY-MM-DD" name="startDate" id="datePicker1">
                </div>
            </div>
            <div class="mt-2">
                <input  type="submit" name="btnCreate" class="btn btn-primary me-2" value="Create Work Station Note">
                <a  href="index.php?pagename=employenotes_operations" class="btn btn-label-secondary">Cancel</a>
            </div>
        </form>
        <!-- /Account -->
    </div>

</div>
