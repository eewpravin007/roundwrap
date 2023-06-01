<?php
error_reporting(0);
$user_master = $_SESSION["user"];
$post_array = filter_input_array(INPUT_POST);
if ($post_array["btnSubmit"] == "SAVE CHANGES") {
    unset($post_array["btnSubmit"]);
    $files = $_FILES["profile_pic"];
    if ($files["name"] != "") {
        $extension = explode(".", $files["name"]);
        $file_name = $user_master["firstName"] . "." . $extension[1];
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "uploaded/userprofile/" . $file_name);
        $post_array["streetName"] = $file_name;
    }
    $post_array["cmpName"] = "Round Wrap Industries Ltd";
    UserManager::updateUserDetails($post_array, $user_master["user_id"]);
    $success = "Hurry!! Profile data updated successfully, please logout and relogin to see changes.";

    $query = " SELECT *, "
            . " (SELECT name FROM `generic_entry` WHERE `type` = 'usertype' AND id = um.roleName ) as user_role "
            . " FROM user_master um "
            . " WHERE um.user_id = '" . $user_master["user_id"] . "' ";
    $_SESSION["user"] = MysqlConnection::fetchCustomSingle($query);
    header("location:index.php?pagename=edit_usermanagement");
}
?>
<form id="formAccountSettings" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>Edit Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?pagename=password_usermanagement">
                        <i class="bx bx-lock-alt me-1"></i> Security</a>
                </li>
            </ul>
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="uploaded/userprofile/<?php echo $eployee_user["streetName"] == "" ? "default.jpg" : $eployee_user["streetName"] ?>" alt="user-avatar" class="d-block rounded" height="100" width="100"/>
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" class="account-file-input" 
                                       name="profile_pic" 
                                       accept="image/png, image/jpeg" hidden/>
                            </label>
                            <p class="mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                        </div>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input class="form-control" type="text" id="firstName" name="firstName" value="<?php echo $user_master["firstName"] ?>" autofocus />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" value="<?php echo $user_master["lastName"] ?>" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control" type="text" id="email" name="email" value="<?php echo $user_master["email"] ?>" placeholder="john.doe@example.com" />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Organization</label>
                            <input type="text" class="form-control" id="organization" value="<?php echo $user_master["cmpName"] ?>" value="<>"/>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="phone">Phone Number</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">US (+1)</span>
                                <input type="text" id="phoneNumber" name="phone" class="form-control" placeholder="202 555 0111" value="<?php echo $user_master["phone"] ?>" />
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="streetNo" name="streetNo" placeholder="Address" value="<?php echo $user_master["streetNo"] ?>"/>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">City</label>
                            <input class="form-control" type="text" id="city" name="city" placeholder="Richmond" value="<?php echo $user_master["city"] ?>"/>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">Province</label>
                            <input class="form-control" type="text" id="province" name="province" placeholder="British Columbia" value="<?php echo $user_master["province"] ?>"/>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="zipCode" class="form-label">Postal Code</label>
                            <input class="form-control" type="text" id="postalCode" name="postalCode" placeholder="V6V 3A9" value="<?php echo $user_master["postalCode"] ?>"/>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="country">Country</label>
                            <input class="form-control" type="text" id="state" name="country" placeholder="Canada" value="<?php echo $user_master["country"] ?>"/>
                        </div>

                    </div>
                    <p style="color: green"><?php echo $success ?></p>
                    <div class="mt-2">
                        <input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary me-2" value="SAVE CHANGES">
                        <a href="index.php"  class="btn btn-label-secondary">
                            BACK
                        </a>
                    </div>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
</form>
