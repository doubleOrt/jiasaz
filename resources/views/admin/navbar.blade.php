@php

$NAVBAR_USER_IMAGE = ($user->profile_image_path != "") ? $user->profile_image_path : "/images/icon/default-avatar.jpg";
$user = auth()->user();
$user_full_name = $user->first_name . " " . $user->last_name;

@endphp

<div class="page-wrapper">
    <!-- HEADER DESKTOP-->
    <header class="header-desktop3 d-none d-lg-block">
        <div class="section__content section__content--p35">
            <div class="header3-wrap">
                <div class="header__logo">
                    <a href="#">
                        <img src="images/icon/logo-white.png" alt="CoolAdmin" width="200px" style="margin-left:40px;"/>
                    </a>
                </div>
                <div class="header__navbar">
                    <ul class="list-unstyled">
                        <li>
                            <a href="/">
                                <i class="fas fa-home"></i>
                                <span class="bot-line"></span>Home</a>
                        </li>

                        <li>
                        <a href="/admin-view-users">
                            <i class="fas fa-user"></i>
                            <span class="bot-line"></span>Users</a>
                        </li>

                        <li class="has-sub">
                            <a href="#">
                                <i class="fas fa-lock"></i> Roles
                                <span class="bot-line"></span>
                            </a>
                            <ul class="header3-sub-list list-unstyled">
                                <li>
                                    <a href="index.html">View Roles</a>
                                </li>
                                <li>
                                    <a href="index2.html">Add Roles</a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="has-sub">
                            <a href="#">
                                <i class="fas fa-list-alt"></i>
                                <span class="bot-line"></span>Categories</a>
                            <ul class="header3-sub-list list-unstyled">
                                <li>
                                    <a href="/admin-view-categories">View Categories</a>
                                </li>
                                <li>
                                    <a href="/admin-add-category">Add Categories</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="/admin-view-items">
                                <i class="fas fa-shopping-basket"></i>
                                <span class="bot-line"></span>Items</a>
                        </li>
                    </ul>
                </div>
                <div class="header__tool">
                    <div class="header-button-item has-noti js-item-menu">
                        <i class="zmdi zmdi-notifications"></i>
                        <div class="notifi-dropdown notifi-dropdown--no-bor js-dropdown">
                            <div class="notifi__title">
                                <p>You have 3 Notifications</p>
                            </div>
                            <div class="notifi__item">
                                <div class="bg-c1 img-cir img-40">
                                    <i class="zmdi zmdi-email-open"></i>
                                </div>
                                <div class="content">
                                    <p>You got a email notification</p>
                                    <span class="date">April 12, 2018 06:50</span>
                                </div>
                            </div>
                            <div class="notifi__item">
                                <div class="bg-c2 img-cir img-40">
                                    <i class="zmdi zmdi-account-box"></i>
                                </div>
                                <div class="content">
                                    <p>Your account has been blocked</p>
                                    <span class="date">April 12, 2018 06:50</span>
                                </div>
                            </div>
                            <div class="notifi__item">
                                <div class="bg-c3 img-cir img-40">
                                    <i class="zmdi zmdi-file-text"></i>
                                </div>
                                <div class="content">
                                    <p>You got a new file</p>
                                    <span class="date">April 12, 2018 06:50</span>
                                </div>
                            </div>
                            <div class="notifi__footer">
                                <a href="#">All notifications</a>
                            </div>
                        </div>
                    </div>

                    <div class="account-wrap">
                        <div class="account-item account-item--style2 clearfix js-item-menu">
                            <div class="image">
                                <img src="{{$NAVBAR_USER_IMAGE}}" alt="User Image" />
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#">{{$user_full_name}}</a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <img src="{{$NAVBAR_USER_IMAGE}}" alt="User Image" />
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#">{{$user_full_name}}</a>
                                        </h5>
                                        <span class="email">{{$user->email}}</span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-settings"></i>Setting</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-money-box"></i>Billing</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="zmdi zmdi-power"></i>Logout
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END HEADER DESKTOP-->

    <!-- HEADER MOBILE-->
    <header class="header-mobile header-mobile-2 d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a class="logo" href="index.html">
                        <img src="images/icon/logo-white.png" alt="CoolAdmin" />
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">

                    <li>
                            <a href="/">
                                <i class="fas fa-home"></i>
                                <span class="bot-line"></span>Home</a>
                    </li>

                    <li>
                        <a href="/admin-view-users">
                            <i class="fas fa-user"></i>
                            <span class="bot-line"></span>Users</a>
                    </li>

                    <li class="has-sub">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-lock"></i>Roles</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            <li>
                                <a href="index.html">View Roles</a>
                            </li>
                            <li>
                                <a href="index2.html">Add Roles</a>
                            </li>
                        </ul>
                    </li>

                    <li class="has-sub">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-list-alt"></i>Categories</a>
                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                            <li>
                                <a href="/admin-view-categories">View Categories</a>
                            </li>
                            <li>
                                <a href="/admin-add-category">Add Categories</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                            <a href="/admin-view-items">
                                <i class="fas fa-shopping-basket"></i>
                                <span class="bot-line"></span>Items</a>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <div class="sub-header-mobile-2 d-block d-lg-none">
        <div class="header__tool">
            <div class="header-button-item has-noti js-item-menu">
                <i class="zmdi zmdi-notifications"></i>
                <div class="notifi-dropdown notifi-dropdown--no-bor js-dropdown">
                    <div class="notifi__title">
                        <p>You have 3 Notifications</p>
                    </div>
                    <div class="notifi__item">
                        <div class="bg-c1 img-cir img-40">
                            <i class="zmdi zmdi-email-open"></i>
                        </div>
                        <div class="content">
                            <p>You got a email notification</p>
                            <span class="date">April 12, 2018 06:50</span>
                        </div>
                    </div>
                    <div class="notifi__item">
                        <div class="bg-c2 img-cir img-40">
                            <i class="zmdi zmdi-account-box"></i>
                        </div>
                        <div class="content">
                            <p>Your account has been blocked</p>
                            <span class="date">April 12, 2018 06:50</span>
                        </div>
                    </div>
                    <div class="notifi__item">
                        <div class="bg-c3 img-cir img-40">
                            <i class="zmdi zmdi-file-text"></i>
                        </div>
                        <div class="content">
                            <p>You got a new file</p>
                            <span class="date">April 12, 2018 06:50</span>
                        </div>
                    </div>
                    <div class="notifi__footer">
                        <a href="#">All notifications</a>
                    </div>
                </div>
            </div>

            <div class="account-wrap">
                <div class="account-item account-item--style2 clearfix js-item-menu">
                    <div class="image">
                        <img src="{{$NAVBAR_USER_IMAGE}}" alt="User Image" />
                    </div>
                    <div class="content">
                        <a class="js-acc-btn" href="#">{{$user_full_name}}</a>
                    </div>
                    <div class="account-dropdown js-dropdown">
                        <div class="info clearfix">
                            <div class="image">
                                <a href="#">
                                    <img src="{{$NAVBAR_USER_IMAGE}}" alt="User Image" />
                                </a>
                            </div>
                            <div class="content">
                                <h5 class="name">
                                    <a href="#">{{$user_full_name}}</a>
                                </h5>
                                <span class="email">$user->email</span>
                            </div>
                        </div>
                        <div class="account-dropdown__body">
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-account"></i>Account</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-settings"></i>Setting</a>
                            </div>
                            <div class="account-dropdown__item">
                                <a href="#">
                                    <i class="zmdi zmdi-money-box"></i>Billing</a>
                            </div>
                        </div>
                        <div class="account-dropdown__footer">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="zmdi zmdi-power"></i>Logout
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END HEADER MOBILE -->

    @yield("content")

</div>
<!-- end Page Wrapper -->