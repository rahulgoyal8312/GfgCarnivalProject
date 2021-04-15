<?php
session_start();
include_once "config.php";
include_once "functions.php";

$hash = '';
$time = date('H:i:s');
$isLoggedIn = isLoggedIn();

$analytics = false;
if(isAdmin()) {
    $analytics = @$_GET['analytics'] ? $_GET['analytics'] : false;
}

if(@$pid && @$_SESSION['userid']) {
    $hash = hash_hmac("sha256", $pid.$_SESSION['userid'].$time, HASH_SECRET_KEY);
    $_SESSION['csrf_token'] = $hash;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= @$pageTitle ? $pageTitle : "GeeksforGeeks - Code with Me" ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&family=Roboto&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?= HOST_URL ?>stylesheet/index.css" rel="stylesheet">
    </link>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/heatmap.js/2.0.0/heatmap.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
    <script src="<?= HOST_URL ?>js/index.js"></script>
    <?= $analytics ? '<script src="'.HOST_URL.'js/heatmap.js"></script>' : '' ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var apiURL = '<?= HOST_URL ?>' + "apis/"
        // var apiURL = 'https://adevtest.geeksforgeeks.org/CarnivalProjectApis/apis/'
        // var apiURL = 'http://192.168.0.108:8888/CarnivalProjectHotjar/' + "apis/"
        var baseURL = '<?= HOST_URL ?>'
    </script>
</head>

<body id="bodyWrapper">
    <?= isset($hash) && $hash ? "<input type='hidden' data-time='".$time."' value='".$hash."' id='csrf_token'/>" : "" ?>
    <?= $analytics ? '<div class="body-overlay"></div>' : '' ?>
    <div class="headerWrapper">
        <a href="https://www.geeksforgeeks.org/" aria-label="Logo" class="header-main__logo shrink">
            <div class="_logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="76.533" height="39.026" viewBox="0 0 76.533 39.026"
                    class="ready">
                    <path
                        d="M2380.7 6597.866a12.252 12.252.0 00-.261-1.513l-30.726-.027a12.545 12.545.0 01.908-3.443 12.337 12.337.0 012.739-4.044 12.151 12.151.0 014.018-2.581 12.634 12.634.0 0114.3 3.051l4.852-4.748a18.176 18.176.0 00-6.131-4.331 20.037 20.037.0 00-8.112-1.564 20.25 20.25.0 00-7.671 1.459 19.158 19.158.0 00-6.261 4.07 19.584 19.584.0 00-4.226 6.184 18.7 18.7.0 00-1.487 5.947h-.2a18.674 18.674.0 00-1.489-5.947 19.544 19.544.0 00-4.226-6.184 19.133 19.133.0 00-6.261-4.07 21.354 21.354.0 00-15.783.1 18.2 18.2.0 00-6.131 4.331l4.853 4.748a13.264 13.264.0 0114.3-3.051 12.131 12.131.0 014.017 2.581 12.323 12.323.0 012.74 4.044 12.527 12.527.0 01.908 3.443l-30.726.027a12.256 12.256.0 00-.261 1.513 15 15 0 00-.1 1.773 20.713 20.713.0 001.1 6.783 15.709 15.709.0 003.443 5.686 17.309 17.309.0 006 4.123 20.587 20.587.0 007.983 1.46 20.226 20.226.0 007.669-1.46 19.086 19.086.0 006.261-4.07 19.506 19.506.0 004.226-6.184 18.163 18.163.0 001.153-3.629h.871a18.27 18.27.0 001.151 3.629 19.545 19.545.0 004.226 6.184 19.111 19.111.0 006.261 4.07 20.241 20.241.0 007.671 1.46 20.572 20.572.0 007.981-1.46 17.282 17.282.0 006-4.123 15.717 15.717.0 003.445-5.686 20.726 20.726.0 001.1-6.783A15.259 15.259.0 002380.7 6597.866zm-46.245 5.608a12.1 12.1.0 01-2.766 4.043 12.467 12.467.0 01-4.043 2.583 14.378 14.378.0 01-9.939.052 11.776 11.776.0 01-3.522-2.218 8.459 8.459.0 01-1.8-2.374 13.476 13.476.0 01-1.173-3.208h23.658A11.487 11.487.0 012334.457 6603.475zm38.236 2.086a8.466 8.466.0 01-1.8 2.374 11.771 11.771.0 01-3.522 2.218 14.378 14.378.0 01-9.939-.052 12.491 12.491.0 01-4.044-2.583 12.088 12.088.0 01-2.765-4.043 11.427 11.427.0 01-.415-1.126h11.92v0h11.739A13.509 13.509.0 012372.692 6605.561z"
                        transform="translate(-2304.273 -6578.666)" fill="#2f8d46"></path>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="155" height="21.281" viewBox="0 0 205.805 21.281"
                    aria-hidden="true">
                    <g id="Group_156" data-name="Group 156" transform="translate(26.144 4.527)">
                        <line id="Line_1" data-name="Line 1" x1="1.046" fill="#0f2b3c"></line>
                    </g>
                    <g id="Group_157" data-name="Group 157" transform="translate(56.695 0.004)">
                        <path id="Path_243" data-name="Path 243"
                            d="M1352.9 615.759l-6.714-6.771v6.771h-3.09V594.521h3.09v12.53l6.084-6.056h3.909l-6.988 6.988 7.67 7.782z"
                            transform="translate(-1343.095 -594.521)" fill="#0f2b3c"></path>
                    </g>
                    <g id="Group_158" data-name="Group 158" transform="translate(113.247 6.427)">
                        <path id="Path_244" data-name="Path 244"
                            d="M1504.614 627.712V612.948h3.09v2.558a3.7 3.7.0 011.447-1.91 3.9 3.9.0 012.262-.73 5.447 5.447.0 011.208.112l-.7 3a2.449 2.449.0 00-.842-.082 3.044 3.044.0 00-2.388 1.138 4.676 4.676.0 00-.983 3.16v7.515z"
                            transform="translate(-1504.614 -612.865)" fill="#0f2b3c"></path>
                    </g>
                    <g id="Group_159" data-name="Group 159" transform="translate(70.943 6.509)">
                        <path id="Path_245" data-name="Path 245"
                            d="M1385.943 626.817a5.668 5.668.0 01-2.152-2.683l2.669-1.171a3.743 3.743.0 001.376 1.662 3.657 3.657.0 002.029.572 4.049 4.049.0 001.879-.395 1.266 1.266.0 00.763-1.185 1.367 1.367.0 00-.654-1.2 6.492 6.492.0 00-2.016-.763l-1.662-.409a5.974 5.974.0 01-2.752-1.444 3.452 3.452.0 01-1.089-2.615 3.4 3.4.0 01.722-2.152 4.647 4.647.0 011.948-1.43 6.957 6.957.0 012.67-.5 7.191 7.191.0 013.405.776 4.6 4.6.0 012.125 2.247l-2.615 1.144a2.925 2.925.0 00-2.888-1.608 3.231 3.231.0 00-1.689.409 1.213 1.213.0 00-.681 1.063 1.226 1.226.0 00.518 1.021 4.442 4.442.0 001.526.667l2.043.518a6.573 6.573.0 013.092 1.566 3.5 3.5.0 011.049 2.575 3.72 3.72.0 01-.749 2.3 4.829 4.829.0 01-2.057 1.539 7.44 7.44.0 01-2.887.545A6.781 6.781.0 011385.943 626.817z"
                            transform="translate(-1383.791 -613.101)" fill="#0f2b3c"></path>
                    </g>
                    <g id="Group_160" data-name="Group 160" transform="translate(96.285 6.525)">
                        <path id="Path_246" data-name="Path 246"
                            d="M1463.543 613.146a7.374 7.374.0 107.374 7.374A7.374 7.374.0 001463.543 613.146zm0 11.532a4.228 4.228.0 114.228-4.228A4.228 4.228.0 011463.543 624.678z"
                            transform="translate(-1456.169 -613.146)" fill="#0f2b3c"></path>
                    </g>
                    <g id="Group_161" data-name="Group 161" transform="translate(23.011 6.524)">
                        <path id="Path_247" data-name="Path 247"
                            d="M1261.615 621.145c.017-.232.027-.466.024-.7a7.292 7.292.0 00-.212-1.685 7.375 7.375.0 00-14.537 1.84c0 .236.017.47.04.7a7.263 7.263.0 00.673 2.382 7.374 7.374.0 0013.389-.141l-3.267.034a4.617 4.617.0 01-8.014-2.3zm-11.664-2.266a4.614 4.614.0 018.592-.09z"
                            transform="translate(-1246.891 -613.144)" fill="#0f2b3c"></path>
                    </g>
                    <g id="Group_162" data-name="Group 162" transform="translate(39.461 6.524)">
                        <path id="Path_248" data-name="Path 248"
                            d="M1308.6 621.145c.017-.232.027-.466.025-.7a7.375 7.375.0 10-14.749.155c0 .236.017.47.04.7a7.257 7.257.0 00.672 2.382 7.375 7.375.0 0013.39-.141l-3.268.034a4.616 4.616.0 01-8.014-2.3zm-11.663-2.266a4.614 4.614.0 018.592-.09z"
                            transform="translate(-1293.873 -613.144)" fill="#0f2b3c"></path>
                    </g>
                    <g id="Group_163" data-name="Group 163" transform="translate(85.044 0.245)">
                        <path id="Path_249" data-name="Path 249"
                            d="M1430.636 598.566a2.5 2.5.0 011.8-.549 4.2 4.2.0 011.657.281v-2.752a7.24 7.24.0 00-2.3-.337 4.82 4.82.0 00-3.455 1.278 4.666 4.666.0 00-1.349 3.554v1.417h-2.922v2.752h2.922v12.036h3.091V604.209h4.016v-2.752h-4.016V600.4A2.5 2.5.0 011430.636 598.566z"
                            transform="translate(-1424.063 -595.209)" fill="#0f2b3c"></path>
                    </g>
                    <g id="Group_164" data-name="Group 164" transform="translate(0)">
                        <path id="Path_250" data-name="Path 250"
                            d="M1202.443 605.147a10.637 10.637.0 11-2.72-7.1l-1.983 1.982a7.837 7.837.0 101.656 7.09h-6.883v-2.851h9.895Q1202.443 604.7 1202.443 605.147z"
                            transform="translate(-1181.169 -594.51)" fill="#0f2b3c"></path>
                    </g>
                    <g id="Group_165" data-name="Group 165" transform="translate(179.788 0.004)">
                        <path id="Path_251" data-name="Path 251"
                            d="M1704.467 615.759l-6.714-6.771v6.771h-3.09V594.521h3.09v12.53l6.084-6.056h3.909l-6.988 6.988 7.669 7.782z"
                            transform="translate(-1694.663 -594.521)" fill="#0f2b3c"></path>
                    </g>
                    <g id="Group_166" data-name="Group 166" transform="translate(194.036 6.509)">
                        <path id="Path_252" data-name="Path 252"
                            d="M1737.51 626.817a5.667 5.667.0 01-2.152-2.683l2.67-1.171a3.742 3.742.0 001.375 1.662 3.658 3.658.0 002.03.572 4.051 4.051.0 001.88-.395 1.267 1.267.0 00.763-1.185 1.367 1.367.0 00-.654-1.2 6.492 6.492.0 00-2.016-.763l-1.662-.409a5.974 5.974.0 01-2.751-1.444 3.451 3.451.0 01-1.09-2.615 3.4 3.4.0 01.722-2.152 4.651 4.651.0 011.948-1.43 6.96 6.96.0 012.67-.5 7.191 7.191.0 013.405.776 4.6 4.6.0 012.125 2.247l-2.615 1.144a2.926 2.926.0 00-2.888-1.608 3.232 3.232.0 00-1.689.409 1.214 1.214.0 00-.681 1.063 1.227 1.227.0 00.518 1.021 4.443 4.443.0 001.526.667l2.043.518a6.576 6.576.0 013.092 1.566 3.5 3.5.0 011.049 2.575 3.719 3.719.0 01-.749 2.3 4.833 4.833.0 01-2.057 1.539 7.44 7.44.0 01-2.888.545A6.781 6.781.0 011737.51 626.817z"
                            transform="translate(-1735.358 -613.101)" fill="#0f2b3c"></path>
                    </g>
                    <g id="Group_167" data-name="Group 167" transform="translate(146.104 6.524)">
                        <path id="Path_253" data-name="Path 253"
                            d="M1613.182 621.145c.017-.232.027-.466.025-.7a7.375 7.375.0 10-14.749.155c0 .236.017.47.04.7a7.254 7.254.0 00.673 2.382 7.375 7.375.0 0013.389-.141l-3.268.034a4.616 4.616.0 01-8.014-2.3zm-11.663-2.266a4.615 4.615.0 018.592-.09z"
                            transform="translate(-1598.458 -613.144)" fill="#0f2b3c"></path>
                    </g>
                    <g id="Group_168" data-name="Group 168" transform="translate(162.554 6.524)">
                        <path id="Path_254" data-name="Path 254"
                            d="M1660.165 621.145c.017-.232.027-.466.024-.7a7.375 7.375.0 10-14.749.155c0 .236.017.47.04.7a7.266 7.266.0 00.673 2.382 7.375 7.375.0 0013.389-.141l-3.268.034a4.616 4.616.0 01-8.014-2.3zm-11.663-2.266a4.614 4.614.0 018.592-.09z"
                            transform="translate(-1645.44 -613.144)" fill="#0f2b3c"></path>
                    </g>
                    <g id="Group_169" data-name="Group 169" transform="translate(123.093)">
                        <path id="Path_255" data-name="Path 255"
                            d="M1554.01 605.147a10.636 10.636.0 11-2.72-7.1l-1.983 1.982a7.837 7.837.0 101.656 7.09h-6.884v-2.851h9.895Q1554.01 604.7 1554.01 605.147z"
                            transform="translate(-1532.736 -594.51)" fill="#0f2b3c"></path>
                    </g>
                </svg>
            </div>
        </a>
        <div class="container headerWrapper-container" style="height: inherit;">
            <div class="headerWrapper-inner">
                <ul>
                    <li>
                        <a href="<?= HOST_URL ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?= HOST_URL ?>">Practice</a>
                    </li>
                    <li>
                        <a href="<?= HOST_URL ?>">Premium</a>
                    </li>
                    <li>
                        <a href="<?= HOST_URL ?>">Auth</a>
                    </li>
                </ul>
                <ul>
                    <li class="noPadding">
                        <?php if($isLoggedIn) { ?> 
                            <div class="customDropdown" data-expandable="1">
                                <div class="userAvatar">
                                    <img class="userAvatar-image" src="<?= $isLoggedIn['picture'] ?>"/>
                                </div>
                                <ul class="customDropdown-list">
                                    <?php if(isAdmin()) { ?>
                                    <li class="noPadding">
                                        <a class="dropdown-item d-flex align-items-center" href="<?= HOST_URL."dashboard" ?>">
                                            <i class="material-icons me-3">insights</i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li class="noPadding">
                                        <a class="dropdown-item d-flex align-items-center" href="<?= HOST_URL."user.php" ?>">
                                            <i class="material-icons me-3">person</i>
                                            <span>Profile</span>
                                        </a>
                                    </li>
                                    <li class="noPadding">
                                        <a class="dropdown-item d-flex align-items-center" href="<?= HOST_URL."logout.php" ?>">
                                            <i class="material-icons me-3">exit_to_app</i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        <?php } else { ?> 
                            <a class="signup" href="<?= HOST_URL ?>googleLogin.php">Google Sign In</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>