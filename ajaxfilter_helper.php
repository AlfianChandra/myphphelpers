<?php
function checkIsAjax()
{
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest')) {
        return false;
    }
	return true;
}
