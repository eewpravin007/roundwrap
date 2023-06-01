<?php
$reminderdata = Operatios::listReminderTemplate();
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <table style="width: auto">
        <tr>
            <td style="width: 50%;text-align: left"><h5 class="card-header">Created reminders</h5></td>
            <td style="width: 50%;text-align: right">
                <a href="index.php?pagename=reminders-create_operations" class="btn btn-label-secondary" >
                    <i class="bx bx-plus-circle"></i>&nbsp;CREATE
                </a>
                <a href="index.php?pagename=reminders-calendar_operations" class="btn btn-label-secondary" >
                    <i class="bx bx-calendar"></i>&nbsp;SHOW CALENDAR
                </a>
                &nbsp;
            </td>
        </tr>
    </table>
    <hr/>
    <div class="card-body">
        <div class="row">
            <?php
            $index = 1;
            foreach ($reminderdata as $value) {
                ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card shadow-none bg-transparent border border-secondary mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $value["remindertline"] ?></h5>
                            <p class="card-text">
                                <?php echo $value["reminderbody"] ?>
                            </p>
                            <p class="card-text">
                                <!--<small class="text-muted">-->
                                    <?php echo $value["startDate"] ?>
                                <!--</small>-->
                                &nbsp;
                                <small class="text-muted" style="float: right">
                                    <a href="index.php?pagename=reminders-create_operations&templateid=<?php echo $value["id"] ?>"><i class="bx bx-pencil"></i></a>
                                    &nbsp;&nbsp;
                                    <a href="index.php?pagename=reminders-create_operations"><i class="bx bx-trash"></i></a>
                                </small>
                            </p>
                        </div>
                    </div>
                </div> 
                <?php
            }
            ?> 
        </div>
    </div>
</div>
