<?php

class LeftMenus {

    static function displayMenusWRTUserLogin($menu_type) {
        $userid = $_SESSION["user"]["user_id"];
        $query = "SELECT submenu FROM `tbl_user_menu_mapping`"
                . " WHERE `userid` = '$userid'"
                . " AND `mainmenu` = '$menu_type'"
                . " ORDER BY submenu";
        return MysqlConnection::fetchCustom($query);
    }

    static function menuMappingWithURL($menu_type) {
        $array = array();
        $array["master"]["customer_master"] = ["manage_customermaster&status=active"];
        $array["master"]["profile_master"] = ["manage_profilemaster"];
        $array["master"]["item_master"] = ["manage_itemmaster&status=PVC"];
        $array["master"]["edit_master"] = ["manage_preferencemaster"];
        $array["master"]["step_integration"] = ["manage_profilesteps"];
        $array["master"]["profile_price"] = ["manage_profileprice"];
        $array["master"]["pvc_preferencemaster"] = ["manage_pcvpreferencemaster"];
        $array["master"]["color_master"] = ["listcolor_profilemaster"];
        $array["master"]["workstation_master"] = ["workstation_preferencemaster"];
        $array["master"]["production_tracking"] = ["manage_profilesteps"];
        $array["master"]["category_master"] = ["category_preferencemaster"];
        $array["master"]["label_master"] = ["label_preferencemaster"];

        $array["retial"]["sales_order"] = ["manage_salesorder&status=N"];
        $array["retial"]["purchase_orders"] = ["manage_perchaseorder"];

        $array["production"]["incoming_order"] = ["manage_incomingorder"];
        $array["production"]["packing_slip"] = ["manage_packingslip&searchcate=pvc"];
        $array["production"]["quotation"] = ["manage_quotation"];
        $array["production"]["work_order"] = ["manage_workorder&searchcate=pvc"];
        $array["production"]["production_invoice"] = ["managecreated_invoice"];
        //$array["production"]["production_inventory"] = ["create_productioninventory"];
        $array["production"]["production_po"] = ["manage_laminateorder"];

        $array["system"]["user_management"] = ["manage_usermanagement"];
        //$array["system"]["company_information"] = ["manage_companymaster"];
        //$array["system"]["scanner_details"] = ["manage_scannerdetail"];
        $array["system"]["update_password"] = ["password_usermanagement"];
        $array["system"]["email_history"] = ["manage_emailhistory"];
        $array["system"]["excel_import"] = ["excel_exceldownload"];

        return $array[$menu_type];
    }

    static function showLinkedMenusForUser($category, $page_name) {
        $master_menus = self::displayMenusWRTUserLogin($category);
        $menus_mapping = self::menuMappingWithURL($category);

        $li .= "";
        foreach ($menus_mapping as $displaykey => $display) {
            foreach ($master_menus as $dbmenu) {
                if ($displaykey == $dbmenu["submenu"]) {
                    $menuurl = $display[0];
                    $menuname = ucwords(str_replace("_", " ", $dbmenu["submenu"]));
                    $andurl = "";
                    if ($dbmenu["submenu"] == "workstation_master") {
                        $andurl = "&status=workstation";
                    }
                    //$li .= "<li><a href=index.php?pagename=$menuurl$andurl >$menuname</a></li>";
                    $li .= "<li class='menu-item'>"
                            . "<a href='index.php?pagename=$menuurl$andurl' class='menu-link'>"
                            . "<i class='menu-icon tf-icons bx bx-user-circle'></i>"
                            . "<div data-i18n='$menuname'>$menuname</div>"
                            . "</a>"
                            . "</li>";
                }
            }
        }
        $category_name = $category == "retial" ? "retail" : $category;
        if (count($master_menus) > 0) {
            $master = "<li class='menu-item'>
                            <a href='javascript:void(0)' class='menu-link menu-toggle'>
                                <i class='menu-icon tf-icons bx bx-home-circle'></i>
                                <div data-i18n='".ucwords($category_name)."'>".ucwords($category_name)."</div>
                            </a>
                            <ul class='menu-sub'>" . $li . "</ul>
                        </li>";
            echo $master;
        }
    }

}
