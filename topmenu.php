<?php
$eployee_user = $_SESSION["user"];
?>
<script>
    function searchMe() {
        var text = document.getElementById("globalSearch").value;
        if (text.length >= 4) {
            window.find(text);
        }
    }
</script>
<ul class="navbar-nav flex-row align-items-center ms-auto">
    <li style="vertical-align: middle">
        <table class="dt-select-table table table-bordered" style="margin-top: 15px">
            <tr>
                <td><b>PVC DOORS</b></td>
                <td><b style="color: red;font-size: 16px"><?php echo Production::getProdOrderStatestic("pvccount")?></b></td>
                <td><b>LAMINATE</b></td>
                <td><b style="color: red;font-size: 16px"><?php echo Production::getProdOrderStatestic("lamicount")?></b></td>
            </tr>
        </table>
    </li>
    <li>&nbsp;&nbsp;&nbsp;</li>
    <li>
        <input type="text" onkeyup="searchMe()" name="globalSearch" id="globalSearch" placeholder="Search text" class="form-control" >
    </li>

    <!-- Style Switcher -->
    <!-- chat box -->
    <a href=".gitignore"></a>
    <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
        <a class="nav-link dropdown-toggle hide-arrow" 
           href="index.php?pagename=view_chatbot" >
            <i class="bx bx-bell bx-sm"></i>
            <span class="badge bg-danger rounded-pill badge-notifications">0</span>
        </a>
    </li>

    <!-- User -->
    <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
                <img src="uploaded/userprofile/<?php echo $eployee_user["streetName"] == "" ? "default.jpg" : $eployee_user["streetName"] ?>" alt class="rounded-circle" />
            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="index.php?pagename=profile_usermanagement">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                                <img src="uploaded/userprofile/<?php echo $eployee_user["streetName"] == "" ? "default.jpg" : $eployee_user["streetName"] ?>" alt class="rounded-circle" />
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <span class="fw-semibold d-block lh-1">
                                <?php echo ucwords($eployee_user["firstName"] . " " . $eployee_user["lastName"]) ?>
                            </span>
                            <span class="fw-normal d-block lh-1">
                                <?php echo $eployee_user["email"] ?>
                            </span>
                            <small><?php echo $eployee_user["user_role"] ?></small>
                        </div>
                    </div>
                </a>
            </li>
            <li><div class="dropdown-divider"></div></li>
            <li>
                <a class="dropdown-item" href="index.php?pagename=profile_usermanagement">
                    <i class="bx bx-user"></i>
                    <span class="align-middle">View Profile</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="index.php?pagename=edit_usermanagement">
                    <i class="bx bx-pencil"></i>
                    <span class="align-middle">Edit Profile</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="index.php?pagename=password_usermanagement">
                    <i class="bx bx-package"></i>
                    <span class="align-middle">Update Password</span>
                </a>
            </li>
            <li><div class="dropdown-divider"></div></li>
            <li>
                <a class="dropdown-item" href="index.php?pagename=employenotes-session_operations">
                    <i class="bx bx-note"></i>
                    <span class="align-middle">My Notes</span>
                </a>
            </li>
            <li><div class="dropdown-divider"></div></li>
            <li>
                <a class="dropdown-item" href="index.php?pagename=faq_faq">
                    <i class="bx bx-help-circle me-2"></i>
                    <span class="align-middle">FAQ</span>
                </a>
            </li>
            <li><div class="dropdown-divider"></div></li>
            <li>
                <a class="dropdown-item" href="logout.php">
                    <i class="bx bx-power-off me-2"></i>
                    <span class="align-middle">Log Out</span>
                </a>
            </li>
        </ul>
    </li>
    <!--/ User -->
</ul>