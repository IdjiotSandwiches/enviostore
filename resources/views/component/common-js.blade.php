<script>
    function customFetch(url, options = {}) {
        options.headers = {
            ...options.headers,
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }

        return fetch(url, options);
    }

    function checkEmptyPlaceholder(placeholder) {
        return placeholder.hasChildNodes();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');

        if(form) {
            form.addEventListener('submit', function () {
                document.querySelector('button[type="submit"]').disabled = true;
                const spinner = document.querySelector('div[role="status"]');

                if(spinner) {
                    spinner.classList.toggle('hidden');
                }
            });
        }

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

        const successToast = baseToast.mixin({
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

        @if (Session::has('status'))
            {{ Session::get('status') }}Toast.fire({
                icon: '{{ Session::get('status') }}',
                titleText: '{{ Session::get('message') }}',
            });
        @endif
    });
</script>
