<?php
$emaildata = Operatios::listEmailTemplate();
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>

<div class="card mb-4">
    <h5 class="card-header">Created email templates</h5>
    <div class="card-body">
        <table style="width: auto">
            <tr>
                <td>
                    <a href="index.php?pagename=emailtemplate-create_operations" class="btn btn-label-secondary" >
                        <i class="bx bx-plus"></i>CREATE
                    </a>
                    <a target="_blank" href="#"  class="btn btn-label-secondary" >
                        <i class="bx bx-import"></i>EXPORT
                    </a>
                </td>
            </tr>
        </table>
        <br/>
        <table class="dt-select-table table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>#</th>
                    <th>#</th>
                    <th>#</th>
                    <th>Subject Line</th>
                    <th>Highlight Text</th>
                    <th>Email Body</th>
                    <th>Attachment</th>
                    <th>Created Date</th>
                    <th>Target Customers</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                foreach ($emaildata as $value) {
                    ?>
                    <tr>
                        <td><?php echo $index++ ?></td>
                        <td>
                            <a title="Test Template"
                               href="index.php?pagename=emailtemplate-test_operations&templateid=<?php echo $value["id"] ?>">
                                <i class="bx bx-bulb"></i>
                            </a>
                        </td>
                        <td>
                            <a  title="Edit Template"
                                href="index.php?pagename=emailtemplate-create_operations&templateid=<?php echo $value["id"] ?>">
                                <i class="bx bx-pencil"></i>
                            </a>
                        </td>
                        <td>
                            <a  title="Delete Template"
                                href="index.php?pagename=emailtemplate-create_operations&templateid=<?php echo $value["id"] ?>&flag=delete">
                                <i class="bx bx-trash-alt"></i>
                            </a>
                        </td>
                        <td class="break-me"><?php echo $value["subjectline"] ?></td>
                        <td class="break-me"><?php echo $value["impText"] ?></td>
                        <td class="break-me"><?php echo $value["emailbody"] ?></td>
                        <td class="break-me">
                            <img src="<?php echo $value["emailattachment"] ?>" style="width: 50px;height: 50px;border-radius: 50px">
                        </td>
                        <td class="break-me"><?php echo $value["sendDate"] ?></td>
                        <td class="break-me"><?php echo $value["sendDate"] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
