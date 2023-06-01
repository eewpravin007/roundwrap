<?php
$employe_user = $_SESSION["user"];
$entred_orders = EmployeeUser::ordersByEmployeId('Arman');
?>
<!-- Header -->
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="user-profile-header-banner">
                <!--<img src="assets/img/pages/profile-banner.png" alt="Banner image" class="rounded-top" />-->
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    <img
                        src="assets/img/avatars/1.png"
                        alt="user image"
                        class="d-block h-auto ms-0 ms-sm-4 rounded-3 user-profile-img"
                        style="width: 50%"/>
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                    <div
                        class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4"
                        >
                        <div class="user-profile-info">
                            <h4><?php echo ucwords($employe_user["firstName"] . " " . $employe_user["lastName"]) ?></h4>
                            <ul
                                class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2"
                                >
                                <li class="list-inline-item fw-semibold"><i class="bx bx-pen"></i> <?php echo $employe_user["user_role"] ?></li>
                                <li class="list-inline-item fw-semibold"><i class="bx bx-map"></i> <?php echo $employe_user["province"] . " " . $employe_user["city"] ?> </li>
                                <li class="list-inline-item fw-semibold">
                                    <i class="bx bx-calendar-alt"></i> Joined <?php echo $employe_user["createdDate"] ?>
                                </li>
                            </ul>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-primary text-nowrap">
                            <i class="bx bx-user-check"></i> Create Task
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Header -->
<!-- User Profile Content -->
<div class="row">
    <div class="col-xl-3 col-lg-5 col-md-5">
        <!-- About User -->
        <div class="card mb-4">
            <div class="card-body">
                <small class="text-muted text-uppercase">About</small>
                <ul class="list-unstyled mb-4 mt-3">
                    <li class="d-flex align-items-center mb-3">
                        <i class="bx bx-user"></i><span class="fw-semibold mx-2">Full Name:</span>
                        <span><?php echo ucwords($employe_user["firstName"] . " " . $employe_user["lastName"]) ?></span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="bx bx-check"></i><span class="fw-semibold mx-2">Status:</span> <span>Active</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="bx bx-star"></i><span class="fw-semibold mx-2">Role:</span> <span><?php echo $employe_user["user_role"] ?></span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="bx bx-flag"></i><span class="fw-semibold mx-2">Country:</span> <span><?php echo $employe_user["province"] . " " . $employe_user["city"] ?></span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="bx bx-detail"></i><span class="fw-semibold mx-2">Languages:</span>
                        <span>English</span>
                    </li>
                </ul>
                <small class="text-muted text-uppercase">Contacts</small>
                <ul class="list-unstyled mb-4 mt-3">
                    <li class="d-flex align-items-center mb-3">
                        <i class="bx bx-phone"></i><span class="fw-semibold mx-2">Contact:</span>
                        <span><?php echo $employe_user["phone"] ?></span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="bx bx-chat"></i><span class="fw-semibold mx-2">Skype:</span> <span><?php echo $employe_user["skypeid"] ?></span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="bx bx-envelope"></i><span class="fw-semibold mx-2">Email:</span>
                        <span><?php echo $employe_user["username"] ?></span>
                    </li>
                </ul>
                <small class="text-muted text-uppercase">Teams</small>
                <ul class="list-unstyled mt-3 mb-0">
                    <li class="d-flex align-items-center mb-3">
                        <i class="bx bxl-github text-primary me-2"></i>
                        <div class="d-flex flex-wrap">
                            <span class="fw-semibold me-2">Roundwrap Management Platform</span><span>Admin</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <div class="col-xl-5 col-lg-7 col-md-7">
        <!-- Activity Timeline -->
        <div class="card card-action mb-4">
            <div class="card-body">
                <small class="text-muted text-uppercase">Last Order Entries</small>
                <br/>
                <br/>
                <ul class="timeline ms-2">
                    <?php
                    $index = 0;
                    foreach ($entred_orders as $orders) {
                        ?>
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point timeline-point-<?php echo GenericSetting::getColorByIndex($index) ?>"></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">
                                        <?php echo $orders["so_no"] . " - " . $orders["cust_companyname"] ?> 
                                    </h6>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div>
                                        <span class="mb-0">
                                            <?php echo $orders["po_no"] ?>, <?php echo $orders["prof_id"], ", " ?> (<?php echo $orders["sub_prof_id"] ?>)
                                            <br/>
                                        </span>
                                        <span>
                                            <?php echo "Total " . $orders["total_pieces"] . " doors" ?> need to deliver in <?php echo $orders["daysLeft"] ?> day/s</span>
                                    </div>
                                </div>
                            </div>
                        </li> 
                        <?php
                        $index++;
                    }
                    ?>
                    <li class="timeline-end-indicator"><i class="bx bx-check-circle"></i></li>
                </ul>
                <center>
                    <a href="index.php?pagename=inproduction_dashboard">
                        <button type="button" class="btn btn-sm btn-label-warning">
                            <span class="tf-icons bx bx-window"></span>&nbsp;Load More
                        </button>
                    </a>
                </center>
            </div>
        </div> 
    </div>
    <div class="col-xl-4 col-lg-5 col-md-5">
        <!-- About User -->
        <div class="card mb-4">
            <div class="card-body">
                <small class="text-muted text-uppercase">My Task</small>
            </div>
        </div>
    </div>
</div>