<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>

<script>
    document.addEventListener('invalid', function (event) {
        event.target.setCustomValidity('Preencha este campo.');
    }, true);

    document.addEventListener('input', function (event) {
        event.target.setCustomValidity('');
    }, true);

    document.addEventListener('submit', function (event) {
        var form = event.target;

        if (form && form.dataset && form.dataset.confirmDelete !== undefined) {
            if (!confirm('Deseja continuar com essa ação?')) {
                event.preventDefault();
            }
        }
    });
</script>
