<?php
$reminderdata = Operatios::listBussinessNoteTemplate();
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">Business Notes Note</h5>
    <div class="card-body">
        <table style="width: auto">
            <tr>
                <td>
                    <a href="index.php?pagename=bussinessnote-create_operations" class="btn btn-label-secondary" >
                        <i class="bx bx-plus-circle"></i>&nbsp;CREATE
                    </a>
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
                    <th>For Customer</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Send Date</th>
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
                            <a title=""
                               href="index.php?pagename=bussinessnote-create_operations&templateid=<?php echo $value["id"] ?>">
                                <i class="bx bx-trash-alt"></i>
                            </a>
                        </td>
                        <td>
                            <a  title="Edit Template"
                                href="index.php?pagename=bussinessnote-create_operations&templateid=<?php echo $value["id"] ?>">
                                <i class="bx bx-pencil"></i>
                            </a>
                        </td>
                        <td class="break-me"><?php echo $value["empname"] ?></td>
                        <td class="break-me"><?php echo $value["remindertline"] ?></td>
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
