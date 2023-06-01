<?php
$userid = filter_input(INPUT_GET, "primary");
$user_dropdown = UserManager::getLoginHistory($userid);
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>
<div class="card md-12">
    <h5 class="card-header">Roundwrap - User master Login History</h5>
    <div class="card-body" style="margin-top: -20px">
        <br/>
        <a href="index.php?pagename=master_usermanagement" class="btn btn-label-secondary"> Back To List </a>
        <br/>
        <br/>
        <table class="table table-bordered">
            <thead style="background-color: rgb(220,220,220);">
                <tr >
                    <th style="width: 25px">#</th>
                    <td>Account Name</td>
                    <td>Username</td>
                    <td>Login Time</td>
                    <td>From IP</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                foreach ($user_dropdown as $value) {
                    ?>
                    <tr >
                        <td><?php echo $index++ ?></td>
                        <td ><?php echo ucwords($value["accountname"]) ?></td>
                        <td ><?php echo $value["emailid"] ?>&nbsp;&nbsp;</td>
                        <td ><?php echo date('l, d F Y h:i A', strtotime($value["logintime"])); ?>&nbsp;&nbsp;</td>
                        <td ><?php echo $value["ipaddress"] ?>&nbsp;&nbsp;</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <br/>
        <div style="float: right">
        </div>
    </div>
</div>
