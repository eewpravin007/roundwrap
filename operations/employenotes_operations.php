<?php
$reminderdata = Operatios::listEmployeeNoteTemplate();

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
    <h5 class="card-header">Work Station Note</h5>
    <div class="card-body">
        <table style="width: auto">
            <tr>
                <td>
                    <a href="index.php?pagename=employenotes-create_operations" class="btn btn-label-secondary" >
                        <i class="bx bx-plus-circle"></i>&nbsp;CREATE
                    </a>
                    <!--                    <a href="index.php?pagename=reminders-calendar_operations" class="btn btn-label-secondary" >
                                            <i class="bx bx-calendar"></i>&nbsp;SHOW CALENDAR
                                        </a>-->
                </td>
            </tr>
        </table>
        <br/>
        <table class="dt-select-table table table-bordered">
            <thead>
                <tr>
                    <th style="width: 25px">#</th>
                    <th style="width: 25px">#</th>
                    <th style="width: 25px">#</th>
                    <th style="width: 150px">Process&nbsp;Mode</th>
                    <th>Description</th>
                    <th style="width: 150px">Need by Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                foreach ($reminderdata as $value) {
                    ?>
                    <tr>
                        <td><?php echo $index++ ?></td>
                        <td>
                            <a title="Delete Note"
                               href="index.php?pagename=employenotes-create_operations&templateid=<?php echo $value["id"] ?>">
                                <i class="bx bx-trash-alt"></i>
                            </a>
                        </td>
                        <td>
                            <a  title="Edit Note"
                                href="index.php?pagename=employenotes-create_operations&templateid=<?php echo $value["id"] ?>">
                                <i class="bx bx-pencil"></i>
                            </a>
                        </td>
                        <td >
                            <span class='badge bg-label-<?php echo $value["empid"] ?>'>
                                <?php echo $value["empname"] ?>
                            </span>
                        </td>
                        <td class="break-me"><?php echo $value["reminderbody"] ?></td>
                        <td class="break-me"><?php echo $value["startDate"] ?></td>

                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
