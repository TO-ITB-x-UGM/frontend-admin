<?php

function showAlert()
{
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        $title = $alert['title'] ? $alert['title'] : "Alert !";
        $message = $alert['message'];
        $type = $alert['type'];
        $icon = "";
        switch ($type) {
            case "danger":
                $icon = "fas fa-ban";
                break;
            case "info":
                $icon = "fas fa-info";
                break;
            case "warning":
                $icon = "fas fa-exclamation-triangle";
                break;
            case "success":
                $icon = "fas fa-check";
                break;
        }
        $alertHTML = <<<EOD
            <div class="alert alert-$type alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon $icon"></i> $title</h5>
                $message
            </div>
        EOD;
        echo $alertHTML;
        unset($_SESSION['alert']);
    }
}

function setAlert($message, $type = 'danger', $title = 'Alert!')
{
    $_SESSION['alert'] = [
        'message' => $message,
        'type' => $type,
        'title' => $title
    ];
}
