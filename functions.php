<?php

function isLoggedIn () {
    if(@$_SESSION['loggedin']) {
        return $_SESSION;
    }
    return false;
}

function isAdmin () {
    $isLoggedIn = isLoggedIn();
    if($isLoggedIn && @$isLoggedIn['level'] == ADMIN_LEVEL) {
        return true;
    }
    return false;
}

function getInfoListType ($type = 'fire') {
    $html = '<div class="info fire">
        <span class="material-icons fire">local_fire_department</span>
        <span>On Fire</span>
    </div>';
    switch($type) {
        case 'trending': {
            $html = '<div class="info trending">
                <span class="material-icons">trending_up</span>
                <span>Trending</span>
            </div>';
            break;
        }
        case 'fire': break;
        default: {
            $html = '';
        }
    }
    return $html;
}

function getFeaturedCard () {
    $pid = 1004;
    $content = POST_LIST[$pid];

    return '
    <a href="'.HOST_URL.'pages/post.php?pid='.$pid.'" class="noDecoration">
        <div class="d-flex flex-column">
            <div class="imgWrap">
                <img src="'.$content['image'].'" alt="'.$content['title'].'">
            </div>
            <div class="head">'.$content['title'].'</div>
            <div class="excerpt">'.$content['excerpt'].'</div>
        </div>
    </a>';
}

function setActiveTab ($current, $tab) {
    if($current == $tab) {
        return "active";
    }
    return "";
}