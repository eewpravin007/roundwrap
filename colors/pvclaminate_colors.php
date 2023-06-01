<?php
$category = filter_input(INPUT_GET, "category");
$color_name = filter_input(INPUT_GET, "color_name");
$sub_page = filter_input(INPUT_GET, "sub_page");

?>
<style>
    .dt-select-table thead{
        background-color: rgb(240,240,240);
    }
</style>
<div class="card md-12">
    <h5 class="card-header">Excellent!!!.. Check yours color details and orders for <i><?php echo $category?>, <?php echo $color_name?></i> </h5>
    <form class="card-body" method="POST">
        <a href="index.php?pagename=pvclaminate_colors&category=<?php echo $category ?>&sub_page=colorlist_colors" 
           class="btn btn-label-secondary <?php echo $sub_page == "colorlist_colors" ? "active" : "" ?>">
            COLORS LIST
        </a>

        <a href="index.php?pagename=pvclaminate_colors&category=<?php echo $category ?>&sub_page=colorgroup_colors" 
           class="btn btn-label-secondary <?php echo $sub_page == "colorgroup_colors" ? "active" : "" ?>">
            COLORS GROUP
        </a> 
        <hr>
    </form>
    <?php
    include 'colors/' . $sub_page . ".php";
    ?>

</div>
