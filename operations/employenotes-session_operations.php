<?php
$firstName = $_SESSION["user"]["firstName"] . " " . $_SESSION["user"]["lastName"];
$empid = $_SESSION["user"]["user_id"];

$reminderdata = Operatios::listEmployeeNoteTemplateSession($empid);
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">Dear <?php echo $firstName ?> please find administrator notes</h5>
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
                                <small class="text-muted"><?php echo $value["startDate"] ?></small>
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
