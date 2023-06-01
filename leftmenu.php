<?php
$active_category = filter_input(INPUT_GET, "category");
?>
<ul class="menu-inner">
    <!-- Dashboards -->
    <li class="menu-item <?php echo $page_name == "" ? "active" : "" ?>">
        <a href="index.php" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>

    <li class="menu-item <?php echo $page_name == "main_dashboard" ? "active" : "" ?>">
        <a href="index.php?pagename=main_dashboard" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-globe"></i>
            <div data-i18n="Search & Report">Search & Report</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="index.php?pagename=main_dashboard" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-search"></i>
                    <div data-i18n="Search With SO">Search SO/PO</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=search_customermaster" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Customer Search">Customer Search</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=globle_dashboard" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-globe"></i>
                    <div data-i18n="Globel Search">Globel Search</div>
                </a>
            </li>
            <hr class="dropdown-divider"/>
            <li class="menu-item">
                <a href="index.php?pagename=workstationloadtable_dashboard&date_for=<?php echo date("m-Y") ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-barcode"></i>
                    <div data-i18n="Prod Monthly Report">Prod&nbsp;Monthly&nbsp;Report</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=color_reports" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-tag"></i>
                    <div data-i18n="Color Report">Color&nbsp;Report</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="index.php?pagename=profile_reports&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-note"></i>
                    <div data-i18n="Profile Report">Profile&nbsp;Report</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=delayed_workorder" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-time"></i>
                    <div data-i18n="Delay Order Report">Delay&nbsp;Order&nbsp;Report</div>
                </a>
            </li>
            <hr class="dropdown-divider"/>
            <li class="menu-item">
                <a href="index.php?pagename=history_customermaster" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-lock"></i>
                    <div data-i18n="History Orderes">History Orderes</div>
                </a>
            </li> 
        </ul>
    </li>

    <li class="menu-item <?php echo $page_name == "excelexport" ? "active" : "" ?>">
        <a href="index.php?pagename=main_dashboard" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-usb"></i>
            <div data-i18n="Settings & Master">Settings & Master</div>
        </a>
        <ul class="menu-sub">
            <!--            <li class="menu-item">
                            <a href="#" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-webcam"></i>
                                <div data-i18n="System Setting">System Setting</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-user-check"></i>
                                <div data-i18n="Users Setting">Users Setting</div>
                            </a>
                        </li>
                        <hr class="dropdown-divider"/>-->
            <li class="menu-item">
                <a href="index.php?pagename=manage_customermaster" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-circle"></i>
                    <div data-i18n="Customer Master">Customer Master</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=master_usermanagement" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-check"></i>
                    <div data-i18n="User Master">User Master</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=manage_vendor" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-pin"></i>
                    <div data-i18n="Vendor Master">Vendor Master</div>
                </a>
            </li>
            <hr class="dropdown-divider"/>
            <li class="menu-item">
                <a href="index.php?pagename=master_profiles&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-note"></i>
                    <div data-i18n="Profile Masters">Profile Masters</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=master_colors&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-tag"></i>
                    <div data-i18n="Colors Master">Colors Master</div>
                </a>
            </li>
<!--            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-barcode"></i>
                    <div data-i18n="Work Station Master">Work Station Master</div>
                </a>
            </li>-->
<!--            <li class="menu-item">
                <a href="index.php?pagename=manage_sendemail" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-send"></i>
                    <div data-i18n="Email List Master">Email List Master</div>
                </a>
            </li>-->
<!--            <hr class="dropdown-divider"/>
            <li class="menu-item">
                <a href="index.php?pagename=download_excelopr" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-import"></i>
                    <div data-i18n="Import Master">Import Master</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=import_excelopr" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-export"></i>
                    <div data-i18n="Export Master">Export Master</div>
                </a>
            </li>-->

        </ul>
    </li>

    <li class="menu-item <?php echo ($page_name == "manage_packingslip" && $active_category == "PVC") ? "active" : "" ?>">
        <a href="index.php?pagename=manage_packingslip" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-search"></i>
            <div data-i18n="PVC Production">PVC Production</div>
        </a>
        <ul class="menu-sub">

            <li class="menu-item">
                <a href="index.php?pagename=manage_packingslip&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-notepad"></i>
                    <div data-i18n="Packing Slip">Packing Slip</div>
                </a>
            </li>
<!--            <li class="menu-item">
                <a href="index.php?pagename=manage_quotation&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-repeat"></i>
                    <div data-i18n="Quotations">Quotations</div>
                </a>
            </li>-->
            <li class="menu-item">
                <a href="index.php?pagename=manage_workorder&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-table"></i>
                    <div data-i18n="Work Order">Work Order</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=planning_packingslip&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-play"></i>
                    <div data-i18n="Production Planning">Production Planning</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=calendar_packingslip&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Production Calendar">Production Calendar</div>
                </a>
            </li>
            <hr class="dropdown-divider"/>
            <li class="menu-item">
                <a href="index.php?pagename=manage_invoicing&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dollar"></i>
                    <div data-i18n="Invoice">Invoice</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=workstation_dashboard&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-barcode"></i>
                    <div data-i18n="Work Stations">Work Stations</div>
                </a>
            </li>
<!--            <li class="menu-item">
                <a href="index.php?pagename=pvclaminate_colors&category=PVC&sub_page=colorgroup_colors" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-abacus"></i>
                    <div data-i18n="Colors Groups">Colors Groups</div>
                </a>
            </li>-->
            <li class="menu-item">
                <a href="index.php?pagename=group_profiles&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-wallet"></i>
                    <div data-i18n="Profiles Groups">Profiles Groups</div>
                </a>
            </li>
            <hr class="dropdown-divider"/>
            <li class="menu-item">
                <a href="index.php?pagename=pendingaklment_customermaster&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-mail-send"></i>
                    <div data-i18n="Pending Acknowledge">Pending Acknowledge</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=pendingworkoder_customermaster&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cart"></i>
                    <div data-i18n="Over-Due Orders">Over-Due Orders</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=delayed_workorder&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-window-open"></i>
                    <div data-i18n="Late Orders">Late Orders</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=pendingdelivery_customermaster&category=PVC" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-car"></i>
                    <div data-i18n="Pending Delivery">Pending Delivery</div>
                </a>
            </li>
        </ul>
    </li>

    <li class="menu-item <?php echo ($page_name == "manage_packingslip" && $active_category == "Laminate") ? "active" : "" ?>">
        <a href="index.php?pagename=manage_packingslip" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-search"></i>
            <div data-i18n="Laminate Production">Laminate Production</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="index.php?pagename=manage_packingslip&category=Laminate" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-notepad"></i>
                    <div data-i18n="Packing Slip">Packing Slip</div>
                </a>
            </li>
<!--            <li class="menu-item">
                <a href="index.php?pagename=manage_quotation&category=Laminate" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-repeat"></i>
                    <div data-i18n="Quotations">Quotations</div>
                </a>
            </li>-->
            <li class="menu-item">
                <a href="index.php?pagename=manage_workorder&category=Laminate" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-table"></i>
                    <div data-i18n="Work Order">Work Order</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=planning_packingslip&category=Laminate" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-play"></i>
                    <div data-i18n="Production Planning">Production Planning</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=calendar_packingslip&category=Laminate" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Production Calendar">Production Calendar</div>
                </a>
            </li>
            <hr class="dropdown-divider"/>
            <li class="menu-item">
                <a href="index.php?pagename=manage_invoicing&category=Laminate" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dollar"></i>
                    <div data-i18n="Invoice">Invoice</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=workstation_dashboard&category=lmi" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-barcode"></i>
                    <div data-i18n="Work Stations">Work Stations</div>
                </a>
            </li>
<!--            <li class="menu-item">
                <a href="index.php?pagename=pvclaminate_colors&category=Laminate&sub_page=colorgroup_colors" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-abacus"></i>
                    <div data-i18n="Colors Groups">Colors Groups</div>
                </a>
            </li>-->
            <li class="menu-item">
                <a href="index.php?pagename=group_profiles&category=Laminate" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-wallet"></i>
                    <div data-i18n="Profiles Groups">Profiles Groups</div>
                </a>
            </li>
            <hr class="dropdown-divider"/>
            <li class="menu-item">
                <a href="index.php?pagename=pendingaklment_customermaster&category=LAMINATE" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-mail-send"></i>
                    <div data-i18n="Pending Acknowledge">Pending Acknowledge</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=pendingworkoder_customermaster&category=LAMINATE" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cart"></i>
                    <div data-i18n="Over-Due Orders">Over-Due Orders</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=delayed_workorder&category=LAMINATE" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-window-open"></i>
                    <div data-i18n="Late Orders">Late Orders</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=pendingdelivery_customermaster&category=LAMINATE" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-car"></i>
                    <div data-i18n="Pending Delivery">Pending Delivery</div>
                </a>
            </li>
        </ul>
    </li>

<!--

    <li class="menu-item <?php echo $page_name == "excelexport" ? "active" : "" ?>">
        <a href="index.php?pagename=main_dashboard" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-sync"></i>
            <div data-i18n="Inventory">Inventory</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-mail-send"></i>
                    <div data-i18n="Create Purchase Order">Purchase Order</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-mail-send"></i>
                    <div data-i18n="Receiving Order">Receiving Order</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-mail-send"></i>
                    <div data-i18n="Items List">Items List</div>
                </a>
            </li>
            <hr class="dropdown-divider"/>

        </ul>
    </li>-->


<!--    <li class="menu-item <?php echo $page_name == "excelexport" ? "active" : "" ?>">
        <a href="index.php?pagename=main_dashboard" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-slider"></i>
            <div data-i18n="Sales Force">Sales Force</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item">
                <a href="index.php?pagename=emailtemplate_operations" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-mail-send"></i>
                    <div data-i18n="Email Templates">Email Templates</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=reminders_operations" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-time"></i>
                    <div data-i18n="Reminders">Reminders</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=employenotes_operations" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-note"></i>
                    <div data-i18n="Work Station Note">Work Station Note</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=businessnote_operations" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bus"></i>
                    <div data-i18n="Business Notes">Business Notes</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="index.php?pagename=weeklyagenda_operations" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-calendar"></i>
                    <div data-i18n="Weekly Agenda">Weekly Agenda</div>
                </a>
            </li>
        </ul>
    </li>-->



</ul>