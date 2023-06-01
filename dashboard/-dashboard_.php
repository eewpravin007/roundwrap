<?php
?>

<div class="card mb-4">

    <h5 class="card-header">Problem!!!.. No Worries, RoundWrap search will help you to find your order.</h5>
    <form class="card-body" method="POST">
        <div class="row g-3">
            <div class="col-md-2">
                <label class="form-label" for="so_no">Sales Order Number</label>
                <div class="input-group input-group-merge">
                    <input type="text" id="so_no" name="so_no" class="form-control" placeholder="123456" autofocus="" value="<?php echo $so_no ?>"/>
                    <span class="input-group-text" id="po_no2"><i class="bx bx-book"></i></span>
                </div>
            </div>
            <div class="col-md-8">
                <label class="form-label" for="po_no">Purchase Order Number</label>
                <div class="input-group input-group-merge">
                    <input disabled="" type="text" id="po_no" name="po_no" class="form-control" placeholder="PO 0023"  value="<?php echo $master_result["po_no"] ?>" />
                    <span class="input-group-text" id="po_no2"><i class="bx bx-album"></i></span>
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
</div>
 