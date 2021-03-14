<!-- Core -->
<script src="/assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="/assets/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/assets/vendor/jquery-validation/additional-methods.min.js"></script>
<script src="/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="/assets/vendor/js-cookie/js.cookie.js"></script>
<script src="/assets/vendor/select2/dist/js/select2.full.min.js"></script>
<!-- Argon JS -->
<script src="/assets/js/argon.min.js"></script>
<!-- main JS  -->
<script src="/assets/js/main.js"></script>
@if(session()->get('error'))
    <script>
        $(() => {
            $.notify({
                icon: 'fas fa-exclamation-circle',
                message: '{{ session('error') }}'
            },{
                type: 'warning'
            });
        })
    </script>
@endif

@if(session()->get('success'))
    <script>
        $(() => {
            $.notify({
                icon: 'fas fa-check-circle',
                message: '{{ session('success') }}'
            },{
                type: 'success',
            });
        });
    </script>
@endif
@yield('page-specific-scripts')