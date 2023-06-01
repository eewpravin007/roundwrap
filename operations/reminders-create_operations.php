<?php
$templateid = filter_input(INPUT_GET, "templateid");
if ($templateid != "") {
    $template = Operatios::listReminderTemplate($templateid);
}
$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnCreate"] == "Create Template") {
    unset($filter_input_array["btnCreate"]);
    Operatios::createReminderTemplate($templateid, $filter_input_array);
    header("location:index.php?pagename=reminders_operations");
}
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">Create Reminders</h5>
    <div class="card-body">
        <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="remindertline" class="form-label">Reminder Subject Line</label>
                    <input required="" class="form-control" type="text" id="remindertline" 
                           name="remindertline" value="<?php echo $template["remindertline"] ?>" autofocus />
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="reminderbody" class="form-label">Description</label>
                    <textarea required="" class="form-control" type="text" id="reminderbody" name="reminderbody" 
                              style="height: 180px;resize: none"><?php echo $template["reminderbody"] ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="startDate" class="form-label">Reminder Date</label>
                    <input required="" type="text" class="form-control date-picker flatpickr-input active" 
                           value="<?php echo $template["startDate"]?>"
                           placeholder="YYYY-MM-DD" name="startDate" id="datePicker1" >
                </div>
            </div>
            <div class="mt-2">
                <input  type="submit" name="btnCreate" class="btn btn-primary me-2" value="Create Template">
                <a  href="index.php?pagename=reminders_operations" class="btn btn-label-secondary">Cancel</a>
            </div>
        </form>
        <!-- /Account -->
    </div>

</div>
