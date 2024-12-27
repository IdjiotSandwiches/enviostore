<script>
    const profilePicturePlaceholder = document.querySelector('#profile-picture-placeholder');

    function fetchRequest() {
        let url = '{{ route('profile.getProfilePicture') }}';
        profilePicturePlaceholder.replaceChildren();

        setTimeout(function() {
            if(profilePicturePlaceholder.textContent !== '') return;

            let card = `{!! view('component.__profile-skeleton')->render() !!}`;
            profilePicturePlaceholder.insertAdjacentHTML('beforeend', card);
        },200);

        customFetch(url, {
            method: 'GET',
        }).then(response => {
            if(!response.ok) {
                throw new Error();
            }
            return response.json();
        }).then(response => {
            profilePicturePlaceholder.replaceChildren();
            replaceProfilePicture(response);
        }).catch(error => {
            let section = document.querySelector('section');
            let item = `{!! view('component.__fetch-failed')->render() !!}`;
            
            section.replaceChildren();
            section.insertAdjacentHTML('beforeend', item);
        });
    }

    function replaceProfilePicture(response) {
        const profilePicture = response.data;
        let card = `{!! view('profile.component.__profile-picture', [
            'profilePicture' => '::PROFILE_PICTURE::'
        ])->render() !!}`;

        card = card.replace('::PROFILE_PICTURE::', profilePicture);
        profilePicturePlaceholder.insertAdjacentHTML('beforeend', card);
    }
</script>