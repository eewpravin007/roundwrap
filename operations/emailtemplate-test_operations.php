<?php
$templateid = filter_input(INPUT_GET, "templateid");
$template = Operatios::listEmailTemplate($templateid);

$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnCreate"] == "Test Template") {

    
    $targetemail = $filter_input_array["testEmailId"];
    $attachment = $template["emailattachment"];
    $subject = $template["subjectline"];
    $bodymatter = sendEmail($subject, $template["emailbody"] , $template["impText"]);
    $title = $template["subjectline"];
    MysqlConnection::sendEmail($targetemail, $attachment, $subject, $bodymatter, "RoundWrap Official");
    header("location:index.php?pagename=emailtemplate_operations");
}
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">Test Email Template for customers</h5>
    <div class="card-body">
        <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="subjectline" class="form-label">Testing Email</label>
                    <input class="form-control" type="text" name="testEmailId"  />
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="subjectline" class="form-label">Subject Line</label>
                    <input class="form-control" type="text" value="<?php echo $template["subjectline"] ?>" readonly="" />
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="impText" class="form-label">Highlighted Message</label>
                    <input class="form-control" type="text" value="<?php echo $template["impText"] ?>" readonly="" />
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-12">
                    <label for="emailbody" class="form-label">Email Body</label>
                    <textarea class="form-control" type="text" readonly="" style="height: 180px;resize: none"><?php echo $template["emailbody"] ?></textarea>
                </div>
            </div>
            <?php if ($template["emailattachment"] != "") { ?>
                <img src="<?php echo $template["emailattachment"] ?>" style="width: 200px;height: 200px;border-radius: 5px">
            <?php } ?>
            <br/>
            <br/>
            <div class="mt-2">
                <input  type="submit" name="btnCreate" class="btn btn-primary me-2" value="Test Template">
                <a  href="index.php?pagename=emailtemplate_operations" class="btn btn-label-secondary">Cancel</a>
            </div>
        </form>
        <!-- /Account -->
    </div>

</div>

<?php

function sendEmail($subject, $bodymatter, $impText) {
    return "<html>
					<head>
						<title>" . $subject . "</title>
						<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
						<style>
							body {
								font-family: 'Roboto';
								font-size: 22px;
							}
						</style>
					</head>
					<body>
						<table border='1' style='min-width: 75%;border-collapse: collapse;'>
							<!--HEADER-->
							<tr style='height: 10%;padding: 5px;color: white;line-height: 25px;'>
								<td style='padding: 10px;'>
									<img src='https://rmp.roundwrap.com/roundwrap/assets/images/download.png' style='width: 20%;margin-left: -5px;'>
								</td>
							</tr>
							<tr style='height: 10%;padding: 5px;background-color: rgb(105,105,105);color: white;line-height: 25px;'>
								<td style='padding: 10px;color: white'>
									150-1680 Savage Road Richmond , BC V6V 3A9
									<br/>
									F:604.278.1463,&nbsp;&nbsp;&nbsp;&nbsp;T: 604.278.1002,&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
							</tr>

							<!--BODY-->
							<tr style='height: auto;'>
								<td style='padding: 10px;vertical-align: top'>
									<br/>
                                                                        <p>" . $bodymatter . "</p>
									<br/>
                                                                        <p style=color:red>" . $impText . "</p>
									<br/>
								</td>
							</tr>

							<!--FOOTER-->
							<tr>
								<td style='padding: 10px;height: 10%;background-color: rgb(105,105,105);color: white;line-height: 25px;'>
									Best Regards, 
									<br/>
									Round Wrap Ind
									<br/>
									Redefining Excellence In Door Craftsmanship
								</td>
							</tr>
						</table>
					</body>
				</html>";
}
?>
