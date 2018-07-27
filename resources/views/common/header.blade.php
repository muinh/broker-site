<div id="mobile-menu-wrapper" class="mobile-menu-wrapper hidden-sm-down">
    <button class="hamburger hamburger--spin" id="mobile-nav-button" type="button">
        <span class="hamburger-box">
            <span class="hamburger-inner"></span>
        </span>
    </button>
    <div class="menu-title">
        <a href="/">
            <img class="mobile-logo" src="/storage/{{ setting('site.logo') }}">
        </a>
    </div>
    <div class="mobile-nav"></div>
</div>
<header class="section header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="general">
                    <div class="logo">
                        <a href="/"><img src="/storage/{{ setting('site.logo') }}" alt="logo"></a>
                    </div>
                    <div class="profile">
                        <div class="notLoggedIn">
                            <form class="d-flex" id="loginForm">
                                <span class="mt-2 mr-2 text-white">LOGIN:</span>
                                <div class="ui form-field style-default size-sm mr-1">
                                    <input type="email" placeholder="Email" required>
                                </div>
                                <div class="ui form-field style-default size-sm mr-1">
                                    <input type="password" placeholder="Password" required>
                                </div>
                                <button class="btn btn-bottom" type="submit">
                                    <i class="fa fa-send"></i>
                                </button>
                            </form>
                            <div class="d-flex" style="margin-left: 52px;">
                                <a href="/forgot-password" class="forgot-password">Forgot Your Password?</a>
                                <span class="login-errors"></span>
                            </div>
                        </div>
                        <div class="loggedIn d-none">
                            <div class="d-flex align-items-center">
                                    <span class="userInfo">
                                        <span>Welcome:</span>
                                        <span class="userName"></span>
                                        <span>Balance:</span>
                                        <span class="userBalance text-success">$0.00</span>
                                        <span class="userVip"></span>
                                        <div class="userVerification"></div>
                                    </span>
                                <button type="button" class="ui button style-default" id="logoutButton">Logout</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui navigation">
                    @include('common.menu', ['menuItems' => $menus['top-menu']])
                </div>
            </div>
        </div>
    </div>
</header>