<script>
    let successToast;
    let errorToast;
    let infoToast;
    let warningToast;

    function customFetch(url, options = {}) {
        options.headers = {
            ...options.headers,
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }

        return fetch(url, options)
            .then(response => {
                if(!response.ok) throw new Error();
                return response.json();
            }).catch(error => {
                let section = document.querySelector('section');
                let item = `{!! view('component.__fetch-failed')->render() !!}`;
                
                section.replaceChildren();
                section.insertAdjacentHTML('beforeend', item);
            });
    }

    function checkPlaceholder(placeholder) {
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

        successToast = baseToast.mixin({
            background: '#22c55e',
        });

        errorToast = baseToast.mixin({
            background: '#ef4444',
        });

        infoToast = baseToast.mixin({
            background: '#3b82f6',
        });

        warningToast = baseToast.mixin({
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
