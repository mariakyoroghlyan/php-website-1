<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$slug = isset($slug) ? $slug : ''; // Set $slug to an empty string if it's not set

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/front/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="icon" href="/front/images/favicon.png" type="image/png">

    <title>AMBER CAPITAL</title>

</head>
<body>

<header>
    <div class="navigation_container tabletHide">
        <div class="logo">
            <img src="/front/images/logo.svg" alt="logo" onclick="location.href='/'">
        </div>

        <div class="menu">
            <ul class="menu_ul flex_center">
                <li>
                    <a href="/" <?php if ($slug == 'index') echo 'class="active_menu"' ?> >Home</a>
                </li>
                <li>
                    <a href="/home/about" <?php if ($slug == 'about') echo 'class="active_menu"' ?> >About us</a>
                </li>
                <li>
                    <a href="/home/fund" <?php if ($slug == 'fund') echo 'class="active_menu"' ?> >EU-Armenia SME Fund</a>
                </li>
                <li>
                    <a href="/home/portfolio" <?php if ($slug == 'portfolio') echo 'class="active_menu"' ?> >Portfolio</a>
                </li>
                <li>
                    <a href="/home/news" <?php if ($slug == 'news') echo 'class="active_menu"' ?> >News</a>
                </li>
            </ul>
        </div>

        <div class="lang_and_touch_container">
            <div class="language_switcher button flex_center">
                <a href="#">Arm</a>
                <a href="#" class="hide">Eng</a>
            </div>

            <div class="get_intouch flex_center button">
                <span>Get in touch</span>
            </div>
        </div>

    </div>

    <div class="navigation_container_tablet tabletShow">

        <div class="logo_and_open_container">
            <div class="logo">
                <img src="/front/images/logo.svg" alt="logo" onclick="location.href='/'">
            </div>

            <div class="tablet_menu_opener button flex_center">
                <span class="tablet_menu_text menu_open">Menu</span>
                <span class="tablet_menu_text menu_close">Close</span>
            </div>
        </div>

        <div class="tablet_menu">
            <ul class="menu_ul">
                <li>
                    <a href="/" <?php if ($slug == 'index') echo 'class="active_menu"' ?> >Home</a>
                </li>
                <li>
                    <a href="/home/about" <?php if ($slug == 'about') echo 'class="active_menu"' ?> >About us</a>
                </li>
                <li>
                    <a href="/home/fund" <?php if ($slug == 'fund') echo 'class="active_menu"' ?> >EU-Armenia SME Fund</a>
                </li>
                <li>
                    <a href="/home/portfolio" <?php if ($slug == 'portfolio') echo 'class="active_menu"' ?> >Portfolio</a>
                </li>
                <li>
                    <a href="/home/news" <?php if ($slug == 'news') echo 'class="active_menu"' ?> >News</a>
                </li>
            </ul>
            <div class="header_btn_and_lang_box">
                <div class="get_intouch flex_center button">
                    <span>Get in touch</span>
                </div>
                <div class="language_switcher button flex_center">
                    <a href="#">Arm</a>
                    <a href="#" class="hide">Eng</a>
                </div>
            </div>
        </div>


    </div>

</header>


