<script>
    const baseToast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
        iconColor: 'white',
        color: 'white',
        customClass: {
            title: 'font-medium',
        }
    });

    var successToast = baseToast.mixin({
        background: '#22c55e',
    });

    const errorToast = baseToast.mixin({
        background: '#ef4444',
    });

    const infoToast = baseToast.mixin({
        background: '#3b82f6',
    });

    const warningToast = baseToast.mixin({
        background: '#eab308',
    });
</script>
