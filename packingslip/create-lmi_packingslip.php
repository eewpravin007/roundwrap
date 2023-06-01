<?php ?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
    .tblcustom{
        width: 100%;
    }
    .tblcustom td{
        padding: 1px;
        border: solid 1px rgb(220,220,220);
    }
    .tblcustom th{
        height: 40px;
        text-align: center;
        border: solid 1px rgb(220,220,220);
    }
    .inputextend{
        height: 30px;
        border-radius: 0px;
        width: 100%;
        text-align: center;
        border: solid 0px;
    }
</style>

<div class="card">
    <h5 class="card-header">Create PVC Packing Slip</h5>
    <div class="card-body demo-inline-spacing" >
        <table class="table table-bordered">
            <tr>
                <td><b>Order Date</b></td>
                <td><input type="text" class="form-control" autofocus="" value="<?php echo date("Y-m-d") ?>"></td>
                <td><b>Require Date</b></td>
                <td><input type="text" class="form-control"></td>
                <td><b>Production Date</b></td>
                <td><input type="text" class="form-control"></td>
            </tr>
            <tr>
                <td><b>Customer Name</b></td>
                <td><input type="text" class="form-control"></td>
                <td><b>PO Number</b></td>
                <td><input type="text" class="form-control"></td>
                <td><b style="color: red">Urgent Order</b></td>
                <td><input type="text" class="form-control"></td>
            </tr>
            <tr>
                <td><b>Tax Applied</b></td>
                <td><input type="text" class="form-control"></td>
                <td><b>Shipping Method</b></td>
                <td><input type="text" class="form-control"></td>
                <td><b>Shipping Cost</b></td>
                <td><input type="text" class="form-control"></td>
            </tr>
            <tr>
                <td><b>Material Supplied?</b></b></td>
                <td><input type="text" class="form-control"></td>
                <td><b>Expected Arrival</b></td>
                <td><input type="text" class="form-control"></td>
                <td><b>Reminder/Note</b></td>
                <td><input type="text" class="form-control"></td>
            </tr>
            <tr>
                <td><b>Packing Slip Note</b></b></td>
                <td colspan="5"><input type="text" class="form-control"></td>
            </tr>
        </table>
    </div>
</div>
<br/>
<div class="row gy-4">
    <!-- User Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        <!-- User Card -->
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td><b>Door Style</b></td>
                        <td>
                            <select class="form-control" style="width: 100%">
                                <option></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Color Brand</b></td>
                        <td>
                            <select class="form-control" style="width: 100%">
                                <option></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Door Color</b></td>
                        <td>
                            <select class="form-control" style="width: 100%">
                                <option></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Edge Tape Name</b></td>
                        <td>
                            <select class="form-control" style="width: 100%">
                                <option></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Tape Thickness</b></td>
                        <td>
                            <select class="form-control" style="width: 100%">
                                <option></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Bin Number</b></td>
                        <td>
                            <select class="form-control" style="width: 100%">
                                <option></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Board Type</b></td>
                        <td>
                            <select class="form-control" style="width: 100%">
                                <option></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Board Thickness</b></td>
                        <td>
                            <select class="form-control" style="width: 100%">
                                <option></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Grain Direction</b></td>
                        <td>
                            <select class="form-control" style="width: 100%">
                                <option></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Backing</b></td>
                        <td>
                            <select class="form-control" style="width: 100%">
                                <option></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Finish</b></td>
                        <td>
                            <select class="form-control" style="width: 120px">
                                <option></option>
                            </select>
                        </td>
                    </tr>

                </table>
            </div>
        </div>

    </div>
    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

        <div class="card mb-4">

            <table class="table table-bordered">
                <tr>
                    <td style="width: 200px"><b>Having Excel/CSV?</b></td>
                    <td><input type="file" class="form-control"></td>
                    <td style="width: 80px">
                        <a href="#">DOWNLOAD</a>
                    </td>
                </tr>
            </table>

            <div class="table-responsive mb-2" style="max-height: 500px;overflow-y: auto;border-top: solid 1px #d4d8dd">
                <table class="tblcustom">
                    <thead style="background-color: rgb(220,220,220);">
                        <tr style="text-align: center">
                            <th style="width: 35px">#</th>
                            <th>Door&nbsp;Type</th>
                            <th>Quantity</th>
                            <th>Width</th>
                            <th>Height</th>


                            <th>Drill</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($index = 1; $index <= 150; $index++) {
                            ?>    
                            <tr style="text-align: center">
                                <td>&nbsp;&nbsp;<?php echo $index++ ?>&nbsp;&nbsp;</td>
                                <td >
                                    <select class="form-control inputextend" style="width: 120px">
                                        <option></option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control inputextend"  ></td>
                                <td><input type="text" class="form-control inputextend" ></td>
                                <td><input type="text" class="form-control inputextend" ></td>

                                <td><input type="checkbox"></td>
                                <td><input type="text" class="form-control inputextend" style="width: 200px" ></td>

                            </tr>
                            <?php
                        }
                        ?>    
                    </tbody>
                </table>
            </div>

        </div>
        <div class="card mb-4" >
            <div class="mt-2" style="margin: 10px">
                <input type="submit" name="frmAddToGroup"  class="btn btn-label-secondary" value="CREATE PACKING SLIP">
                <input type="submit" name="frmAddToGroup"  class="btn btn-label-secondary" value="EMAIL PACKING SLIP">
                <input type="submit" name="frmAddToGroup"  class="btn btn-label-secondary" value="PRINT PACKING SLIP">
                <input type="submit" name="frmAddToGroup"  class="btn btn-label-secondary" value="PACKING SLIP LIST">
            </div>
        </div>
    </div>
</div>