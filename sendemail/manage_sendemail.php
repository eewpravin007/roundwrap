<?php
//$user_dropdown = UserManager::getAllUserDetails();
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>
<div class="card md-12">
    <h5 class="card-header">Resent email list sent by system</h5>
    <hr/>
    <div class="card-body" style="margin-top: -20px">
        <table class="table table-bordered">
            <thead style="background-color: rgb(220,220,220);">
                <tr >
                    <th>#</th>
                    <th>SHOW</th>
                    <th>HISTORY</th>
                    <th></th>
                    <th>Full&nbsp;Name</th>
                    <th>Email&nbsp;Id</th>
                    <th>Contact&nbsp;Number</th>
                    <th>Create On</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                foreach ($user_dropdown as $value) {
                    ?>
                    <tr >
                        <td><?php echo $index++ ?></td>
                        <td style="text-align: center">
                            <a href="#">
                                <i class="bx bx-show" style="color: gray"></i>
                            </a>
                        </td>
                        <td style="text-align: center">
                            <a title="Click here to see customer order history" href="#">
                                <i class="bx bx-history" style="color: gray"></i>
                            </a>
                        </td>
                        <td>
                            <img style="width: 50px;height: 50px;border-radius: 50px" 
                                 src="uploaded/userprofile/<?php echo $value["streetName"] == "-" ? "default.jpg" : $value["streetName"] ?>">
                        </td>
                        <td><?php echo $value["firstName"] . " " . $value["lastName"] ?></td>
                        <td><?php echo $value["email"] ?></td>
                        <td><?php echo $value["phone"] ?></td>
                        <td><?php echo $value["cmpName"] ?></td>
                        <td><?php echo $value["createdDate"] ?></td>

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
