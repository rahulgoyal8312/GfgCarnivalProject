<?php 
$pid = "home";
include_once "header.php"; 
?>

<div class="container mainWrapper" data-page-id="home">
    <div class="mainWrapper-carousel owl-carousel">
        <?php foreach(BANNER_LIST as $banner) { ?>
            <div class="item">
                <img src="<?= $banner ?>" alt="Banner"/>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-md-8 gridRightPipe">
            <div class="d-flex mainWrapper-content">
                <div class="left">
                    <?= getFeaturedCard() ?>
                </div>
                <div class="right d-flex flex-column">
                    <?php 
                        foreach(POST_LIST as $key => $post) {
                            if(@$post['featured']) continue;
                            if(@$post['ignore']) continue;
                            $metaList = '';
                            foreach($post['meta'] as $m) {
                                $metaList .= '<li>'.$m.'</li>';
                            }
                            $infoList = getInfoListType(@$post['info']);
                            echo '<a href="'.HOST_URL.'pages/post.php?pid='.$key.'" class="noDecoration">
                                <div class="mainWrapper-content_card d-flex align-items-center">
                                    <div class="d-flex flex-column c1">
                                        '.$infoList.'
                                        <div class="head">'.$post['title'].'</div>
                                        <ul class="meta">
                                            '.$metaList.'
                                        </ul>
                                    </div>
                                    <div class="c2">
                                        <img src="'.$post['image'].'" alt="'.$post['title'].'"/>
                                    </div>
                                </div>
                            </a>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex flex-column rightBar">
                <div class="mainHeading">
                    More Links to follow
                </div>
                <ul>
                    <li>
                        <a href="">
                            <span class="rightBar-icon one"></span>
                            <span>Courses at GeeksforGeeks</span>
                            <span class="material-icons">navigate_next</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="rightBar-icon two"></span>
                            <span>Data Structures Tutorial</span>
                            <span class="material-icons">navigate_next</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="rightBar-icon three"></span>
                            <span>Internships at GeeksforGeeks</span>
                            <span class="material-icons">navigate_next</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="rightBar-icon four"></span>
                            <span>Coding Practice</span>
                            <span class="material-icons">navigate_next</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="rightBar-icon five"></span>
                            <span>Data Structures Tutorial</span>
                            <span class="material-icons">navigate_next</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include_once "footer.php"; ?>