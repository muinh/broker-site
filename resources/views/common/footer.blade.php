<footer class="section footer mb-5">
    <div class="navigation mb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner">
                        @include('common.menu', ['menuItems' => $menus['bottom-menu']])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main class="main">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <img src="/images/payments.png?31c84317e4ff67b817d6a11dd57d0668" alt="" class="mw-100 mb-5">&nbsp;&nbsp;
                    <img width="100px" src="/images/vload.png?fb30dd793c42507dbc931a9aa8820282" alt="" class="mw-100 mb-5">
                    <img src="/images/wkBozy4.png?460d9fb8040cc4bc008bb1f2d422e0d5" alt="" class="mw-100 mb-5">
                </div>
            </div>
        </div>
    </main>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner">
                        {!! setting('site.footer_text') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>