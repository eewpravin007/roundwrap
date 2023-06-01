<?php
$templateid = filter_input(INPUT_GET, "templateid");
$flag = filter_input(INPUT_GET, "flag");
$btnname = $flag == "delete" ? "Delete Template" : "Create Template";
if ($templateid != "") {
    $template = Operatios::listEmailTemplate($templateid);
}
$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnCreate"] == "Create Template") {
    unset($filter_input_array["btnCreate"]);
    $ettachment = MysqlConnection::uploadFile($_FILES["emailattachment"], "operations/emailattachment/");
    if ($ettachment != "") {
        $filter_input_array["emailattachment"] = $ettachment;
    }
    $filter_input_array["sendDate"] = date("Y-m-d");
    Operatios::createEmailTemplate($filter_input_array, $templateid);
    header("location:index.php?pagename=emailtemplate_operations");
}else if($filter_input_array["btnCreate"] == "Delete Template"){
    MysqlConnection::deleteOperation("tbl_email_template", "id", $templateid);
    header("location:index.php?pagename=emailtemplate_operations");
}
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">Create Email Template for customers</h5>
    <div class="card-body">
        <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="subjectline" class="form-label">Subject Line</label>
                    <input class="form-control" type="text" id="subjectline" name="subjectline" value="<?php echo $template["subjectline"] ?>" autofocus />
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="impText" class="form-label">Highlighted Message</label>
                    <input class="form-control" type="text" id="subjectline" name="impText" value="<?php echo $template["impText"] ?>" autofocus />
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="emailbody" class="form-label">Email Body</label>
                    <textarea class="form-control" type="text" id="emailbody" name="emailbody" style="height: 180px;resize: none"><?php echo $template["emailbody"] ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="emailattachment" class="form-label">Attachment</label>
                    <input class="form-control" type="file" id="emailattachment" name="emailattachment" value="<?php echo $template["emailattachment"] ?>" autofocus />
                </div>
            </div>
            <?php if ($template["emailattachment"] != "") { ?>
                <div class="row">
                    <div class="mb-3 col-md-12">
                        <a href="<?php echo $template["emailattachment"] ?>" target="_blank">SEE ATTACHMENT</a>
                    </div>
                </div>
            <?php } ?>
            <div class="mt-2">
                <input  type="submit" name="btnCreate" class="btn btn-primary me-2" value="<?php echo $btnname?>">
                <a  href="index.php?pagename=emailtemplate_operations" class="btn btn-label-secondary">Cancel</a>
            </div>
        </form>
        <!-- /Account -->
    </div>

</div>
