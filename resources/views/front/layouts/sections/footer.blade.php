<!-- Footer-->
<footer class="bg-dark py-4 mt-auto">
    <div class="container px-5">
        <div class="row align-items-center justify-content-between flex-column flex-sm-row">
            <div class="col-auto"><div class="small m-0 text-white">Copyright &copy; {{ getSystemSetting('BJCDL_001')->value }} {{ date("Y") }}</div></div>
            <div class="col-auto">
                <a class="link-light small" href="{{ url('privacy') }}">Privacy</a>
                <span class="text-white mx-1">&middot;</span>
                <a class="link-light small" href="{{ url('terms') }}">Terms</a>
                <span class="text-white mx-1">&middot;</span>
                <a class="link-light small" href="{{ url('contact-us') }}">Contact</a>
            </div>
        </div>
    </div>
</footer>