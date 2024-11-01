@include('component.custom-toast')

<script>
    function customFetch(url, options = {}) {
        options.headers = {
            ...options.headers,
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }

        return fetch(url, options);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchIcon = document.querySelector('#search-icon');
        const backBtn = document.querySelector('#back-btn');
        const searchBar = document.querySelector('#search-bar');

        searchIcon.addEventListener('click', function() {
            searchBar.classList.toggle('hidden')
        })

        backBtn.addEventListener('click', function() {
            searchBar.classList.toggle('hidden')
        })

        @if (Session::has('status'))
            {{ Session::get('status') }}Toast.fire({
                icon: '{{ Session::get('status') }}',
                titleText: '{{ Session::get('message') }}',
            });
        @endif
    });
</script>
