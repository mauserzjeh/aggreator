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