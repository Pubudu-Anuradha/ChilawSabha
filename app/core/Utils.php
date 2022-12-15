<?php
function warn($data, $check = 'message')
{
    if (isset($_POST['Submit']) && isset($data[$check])) {
        echo "<div class=\"warn\"> " . $data[$check] . "</div>";
        unset($data[$check]);
    }
}

function success($data, $check = 'message')
{
    if (isset($_POST['Submit']) && isset($data[$check])) {
        echo "<div class=\"success\"> " . $data[$check] . "</div>";
        unset($data[$check]);
    }
}
