<style>
    .dt-fixedcolumns th{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header" style="color: red"><i class="bx bx-globe"></i>Show your weekly agenda</h5>
    <div class="card-body">
        <table style="width: auto">
            <tr>
                <td>
                    <a href="index.php?pagename=weeklyagenda-create_operations" class="btn btn-label-secondary" >
                        <i class="bx bx-plus-circle"></i>&nbsp;CREATE
                    </a>
                </td>
            </tr>
        </table>
        <br/>
        <table class="dt-select-table table dt-fixedcolumns table-bordered">
            <thead>
                <tr>
                    <th style="width: 25px">#</th>
                    <th style="width: 25px">#</th>
                    <th style="width: 25px">#</th>
                    <th style="width: 150px">Date</th>
                    <th style="width: 150px">Day</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $reminderdata = Operatios::listWeeklyAgendaTemplate();
                $index = 1;
                foreach ($reminderdata as $value) {
                    ?>
                    <tr>
                        <td><?php echo $index++ ?></td>
                        <td>
                            <a title=""
                               href="#">
                                <i class="bx bx-bulb"></i>
                            </a>
                        </td>
                        <td>
                            <a  title="Edit Template"
                                href="index.php?pagename=weeklyagenda-create_operations&templateid=<?php echo $value["weeknumber"] ?>">
                                <i class="bx bx-pencil"></i>
                            </a>
                        </td>
                        <td class="break-me"> <?php echo date('l', strtotime($value["startDate"])); ?></td>
                        <td class="break-me"><?php echo $value["startDate"] ?></td>
                        <td class="break-me"><?php echo $value["remindertline"] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>