<?php
$colorList = Colors::getColorDetailsFromCategory($category);
?> 
<div class="row gy-4"  style="margin-top: -70px">
    <div class="col-xl-12 col-lg-5 col-md-5 order-1 order-md-0">
        <form class="card-body" method="POST">
            <div class="row g-3">
                <div class="col-md-10">
                    <label class="form-label" for="color_name">Color Name</label>
                    <div class="input-group input-group-merge">
                        <input type="text" id="color_name" name="color_name" class="form-control" 
                               placeholder="Enter Color Name" autofocus="" value="<?php echo $customer_details ?>"/>
                        <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-password-toggle">
                        <label class="form-label" for="">&nbsp;</label>
                        <div class="input-group input-group-merge">
                            <input  type="submit" class="btn btn-primary me-sm-3 me-1" name="btnSearch" value="Search">
                            <a href="index.php?pagename=main_dashboard" class="btn btn-label-secondary">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div> 
            </div>
        </form>
        <div class="card-body" style="margin-top: -10px">
            <div style="overflow: auto;max-height: 525px;overflow-x: hidden;border-bottom: solid 1px #d4d8dd;border-top: solid 1px #d4d8dd">
                <table class="table table-bordered">
                    <thead style="background-color: rgb(220,220,220);">
                        <tr >
                            <th>#</th>
                            <th>#</th>
                            <th>#</th>
                            <th>#</th>
                            <th>Color&nbsp;CODE</th>
                            <th>Color&nbsp;Name</th>
                            <th>Brand&nbsp;Name</th>
                            <th style="text-align: right">Price</th>
                            <th style="text-align: right">Doors&nbsp;Ordered</th>
                            <th style="text-align: right">Total&nbsp;SQFeet</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 1;
                        foreach ($colorList as $value) {
                            $color_group_key = $category."_".$value["colorname"]."_". $value["id"];
                            ?>
                            <tr >
                                <td><?php echo $index++ ?></td>
                                <td><a href=""><i class="bx bx-edit" style="color: rgb(180,180,180)"></i></a></td>
                                <td>
                                    <a href="index.php?pagename=pvclaminate_colors&category=<?php echo $category?>&sub_page=colorgroup_colors&color_name=<?php echo $color_group_key ?>">
                                        <i>CREATE GROUP</i>
                                    </a>
                                </td>
                                <td>
                                    <a href="index.php?pagename=pvclaminate_colors&category=<?php echo $category?>&sub_page=colorlist_colors&color_name=<?php echo $color_group_key ?>">
                                        <i>+ PO</i>
                                    </a>
                                </td>
                                <td><?php echo $value["colorcode"] ?></td> 
                                <td><?php echo ucwords(strtolower($value["colorname"])) ?></td> 
                                <td><?php echo ucwords(strtolower($value["colorbrand"])) ?></td> 
                                <td style="text-align: right"><?php echo GenericSetting::numberFormat($value["colorprice"]) ?></td> 
                                <td style="text-align: right"><?php echo GenericSetting::numberFormat($value["total_pieces"]) ?></td> 
                                <td style="text-align: right"><?php echo GenericSetting::numberFormat($value["billable_fitsquare"]) ?></td> 
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card-body demo-inline-spacing" style="margin-top: -40px;">
    <a href="#" class="btn btn-label-secondary" ><i class="bx bx-printer me-2"></i> PRINT REPORT</a>
    &nbsp;
    <a href="#" class="btn btn-label-secondary" ><i class="bx bx-mail-send me-2"></i> EMAIL REPORT</a>
    &nbsp;
    <a href="#" class="btn btn-label-secondary" ><i class="bx bx-download me-2"></i> DOWNLOAD REPORT</a>
</div>