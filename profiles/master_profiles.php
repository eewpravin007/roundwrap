<?php
$category_get = filter_input(INPUT_GET, "category");
$category = $category_get == "" ? "PVC" : $category_get;

$filter_input_array = filter_input_array(INPUT_POST);
if ($filter_input_array["btnSearch"] == "Search") {
    
}
$displayarray = Profiles::getProfileForMasterPage($category);
$profilename = $displayarray[0];
$masterdata = $displayarray[1];
$displaycounter = Profiles::getProfileOrderCounter($category);
?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>
<div class="card md-12">
    <h5 class="card-header">RoundWrap - Profiles List</h5>
    <form class="card-body" method="POST">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="profilename">Profile Names</label>
                <div class="input-group input-group-merge">
                    <input name="" class="form-control" id="tablesearch" onkeyup="searchinTable()" name="profilename" />
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-password-toggle">
                    <label class="form-label" for="">&nbsp;</label>
                    <div class="input-group">
                        <a href="index.php?pagename=createedit_profiles&category=PVC" class="btn btn-label-secondary <?php echo $category == "PVC" ? "active" : "" ?>">
                            <i class="bx bx-plus-circle" ></i> Create PVC
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="index.php?pagename=createedit_profiles&category=LAMINATE" class="btn btn-label-secondary <?php echo $category == "LAMINATE" ? "active" : "" ?>">
                            <i class="bx bx-plus-circle" ></i> Create Laminate
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="index.php?pagename=master_profiles&category=PVC" class="btn btn-label-secondary <?php echo $category == "PVC" ? "active" : "" ?>">
                            PVC
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="index.php?pagename=master_profiles&category=LAMINATE" class="btn btn-label-secondary <?php echo $category == "LAMINATE" ? "active" : "" ?>">
                            Laminate
                        </a>
                    </div>
                </div>
            </div> 
        </div>
    </form>
    <div class="card-body" style="margin-top: -20px">
        <div style="overflow: auto;max-height: 550px;overflow-x: hidden;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
            <table class="table table-bordered" id="mastertable">
                <thead style="background-color: rgb(220,220,220);">
                    <tr >
                        <th style="width: 25px">#</th>
                        <th style="width: 25px">#</th>
                        <th style="width: 25px">#</th>
                        <th style="width: 25px">#</th>
                        <th>Category</th>
                        <th>Profile&nbsp;Name</th>
                        <th>Profile&nbsp;Style</th>
                        <th>Profile&nbsp;Price</th>
                        <th style="text-align: right">LR</th>
                        <th style="text-align: right">TR</th>
                        <th style="text-align: right">RR</th>
                        <th style="text-align: right">BR</th>
                        <th style="text-align: left">Doors</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1;
                    foreach ($masterdata as $value) {
                        ?>
                        <tr >
                            <td><?php echo $index++ ?></td>
                            <td style="text-align: center">
                                <a href="index.php?pagename=view_profiles&profileid=<?php echo $value["id"] ?>&category=<?php echo $value["category"] ?>">
                                    <i class="bx bx-show" style="color: gray"></i>
                                </a>
                            </td>
                            <td style="text-align: center">
                                <a href="index.php?pagename=createedit_profiles&profileid=<?php echo $value["id"] ?>&action=edit&category=<?php echo $value["category"] ?>">
                                    <i class="bx bx-pencil" style="color: gray"></i>
                                </a>
                            </td>
                            <td style="text-align: center">
                                <a href="index.php?pagename=delete_profiles&profileid=<?php echo $value["id"] ?>">
                                    <i class="bx bx-trash-alt" style="color: gray"></i>
                                </a>
                            </td>
                            <td><?php echo $value["category"] ?></td>
                            <td><?php echo $value["profilename"] ?></td>
                            <td><?php echo $value["profile"] ?></td>
                            <td><?php echo $value["profiledetailprice"] ?></td>
                            <td style="text-align: right"><?php echo $value["leftrail"] ?></td>
                            <td style="text-align: right"><?php echo $value["toprail"] ?></td>
                            <td style="text-align: right"><?php echo $value["rightrail"] ?></td>
                            <td style="text-align: right"><?php echo $value["bottomrail"] ?></td>
                            <td>
                                <a href="index.php?pagename=profile_reports&category=<?php echo $category ?>&profile=<?php echo $value["profilename"] ?>">
                                    Total <?php echo $displaycounter[$value["profilename"]] ?> Doors
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <br/>
        <div style="float: right">
        </div>
    </div>
</div>
