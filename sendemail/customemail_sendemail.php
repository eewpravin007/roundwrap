<?php 
    $primary = filter_input(INPUT_GET, "");
    $columns = "cust_companyname, cust_email"; 
    $customer = Customer::getCustomerDetailsById($columns, $primary);
    $customername = $customer["cust_companyname"];
    $customeremail = $customer["cust_email"];
    $filter_input_array = filter_input_array(INPUT_POST);
    if($filter_input_array["btnCreate"] == "SEND EMAIL"){
        unset($filter_input_array["btnCreate"]);
        SendEmails::sendPackingSlip($emaildata, $customer);
        header("");
    }
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">Send custom note/email to customer</h5>
    <div class="card-body">
        <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="subjectline" class="form-label">Customer Name and Primary Email</label>
                    <input class="form-control" type="text" id="subjectline" name="customeremail" value="<?php echo "($customername, $customeremail)" ?>" autofocus />
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="subjectline" class="form-label">CC Email Id</label>
                    <input class="form-control" type="text" id="ccemailid" name="ccemailid" autofocus />
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="subjectline" class="form-label">Email Subject</label>
                    <input class="form-control" type="text" id="subjectline" name="subjectline" autofocus />
                </div>
            </div>
            
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="emailbody" class="form-label">Note/Email Body</label>
                    <textarea class="form-control" type="text" id="emailbody" name="emailbody" style="height: 120px;resize: none"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="emailattachment" class="form-label">Attachment</label>
                    <input class="form-control" type="file" id="emailattachment" name="emailattachment" value="<?php echo $template["emailattachment"] ?>" autofocus />
                </div>
            </div>
             
            <div class="mt-2">
                <input  type="submit" name="btnCreate" class="btn btn-primary me-2" value="SEND EMAIL">
                <a  href="index.php?pagename=manage_sendemail" class="btn btn-label-secondary">Cancel</a>
            </div>
        </form>
    </div>

</div>
