<?php
$templateid = filter_input(INPUT_GET, "templateid");
if ($templateid != "") {
    $template = Operatios::listBussinessNoteTemplate($templateid);
}
$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnCreate"] == "Create Note") {
    unset($filter_input_array["btnCreate"]);
    $explaod = explode("__", $filter_input_array["userdetails"]);
    $filter_input_array["empid"] = $explaod[0];
    $filter_input_array["empname"] = $explaod[1];
    unset($filter_input_array["userdetails"]);
    Operatios::createBussinessNoteTemplate($templateid, $filter_input_array);
    header("location:index.php?pagename=businessnote_operations");
}

$dropdownuser = Customer::getCustomerDetails("id, cust_companyname");
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">Create Customer Business Notes</h5>
    <div class="card-body">
        <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="remindertline" class="form-label">To which customer you want to tag the note </label>
                    <select class="form-control" name="userdetails" >
                        <?php
                        foreach ($dropdownuser as $value) {
                            $userkey = $value["id"] . "__" . $value["cust_companyname"];
                            $selected = $value["id"] == $template["empid"] ? "selected" : "";
                            ?>
                            <option value="<?php echo $userkey ?>" <?php echo $selected ?>>
                                <?php echo $value["cust_companyname"]?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="remindertline" class="form-label">Customer note title</label>
                    <input required="" class="form-control" type="text" id="remindertline" 
                           name="remindertline" value="<?php echo $template["remindertline"] ?>" autofocus />
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="reminderbody" class="form-label">Customer Note Description</label>
                    <textarea required="" class="form-control" type="text" id="reminderbody" name="reminderbody" 
                              style="height: 180px;resize: none"><?php echo $template["reminderbody"] ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="startDate" class="form-label">Any Reminder Date?</label>
                    <input required="" type="text" class="form-control date-picker flatpickr-input active" 
                           value="<?php echo $template["startDate"] ?>"
                           placeholder="YYYY-MM-DD" name="startDate" >
                </div>
            </div>
            <div class="mt-2">
                <input  type="submit" name="btnCreate" class="btn btn-primary me-2" value="Create Note">
                <a  href="index.php?pagename=businessnote_operations" class="btn btn-label-secondary">Cancel</a>
            </div>
        </form>
        <!-- /Account -->
    </div>

</div>
