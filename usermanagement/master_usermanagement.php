<?php
$user_dropdown = UserManager::getAllUserDetails();
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>
<div class="card md-12">
    <h5 class="card-header">Roundwrap - User master</h5>
    <div class="card-body" style="margin-top: -20px">
        <br/>
        <a href="#" class="btn btn-label-secondary"> Create User </a>
        <br/>
        <br/>
        <table class="table table-bordered">
            <thead style="background-color: rgb(220,220,220);">
                <tr >
                    <th style="width: 25px">#</th>
                    <th style="width: 25px">SHOW</th>
                    <th style="width: 25px">HIS</th>
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
                            <a href="index.php?pagename=view_usermanagement&primary=<?php echo $value["user_id"]?>">
                                <i class="bx bx-show" style="color: gray"></i>
                            </a>
                        </td>
                        <td style="text-align: center">
                            <a title="Click here to see customer order history" 
                               href="index.php?pagename=history_usermanagement&primary=<?php echo $value["email"]?>">
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
