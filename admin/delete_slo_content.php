<?php
require("includes/function.php");

$sloContentId = isset($_POST['sloContentId']) ? intval($_POST['sloContentId']) : 0;

if ($sloContentId > 0) {
    $sloContentId = mysqli_real_escape_string($mysqli, $sloContentId);

    $query = "DELETE FROM lesson_plan_content WHERE id = $sloContentId";

    if (mysqli_query($mysqli, $query)) {
        echo "success";
    } else {
        echo false;
    }
} else {
    echo "Invalid id";
}
?>
