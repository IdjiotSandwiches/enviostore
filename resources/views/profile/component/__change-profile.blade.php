<script>
    const profilePicturePlaceholder = document.querySelector('#profile-picture-placeholder');

    function fetchRequest() {
        let url = '{{ route('profile.getProfilePicture') }}';
        profilePicturePlaceholder.replaceChildren();

        setTimeout(function() {
            if(checkPlaceholder(profilePicturePlaceholder)) return;

            let card = `{!! view('component.__profile-skeleton')->render() !!}`;
            profilePicturePlaceholder.insertAdjacentHTML('beforeend', card);
        },200);

        customFetch(url, {
            method: 'GET',
        }).then(response => {
            profilePicturePlaceholder.replaceChildren();
            replaceProfilePicture(response);
        });
    }

    function replaceProfilePicture(response) {
        const profilePicture = response.data;
        profilePicturePlaceholder.replaceChildren();

        let card = `{!! view('profile.component.__profile-picture', [
            'profilePicture' => '::PROFILE_PICTURE::'
        ])->render() !!}`;

        card = card.replace('::PROFILE_PICTURE::', profilePicture);
        profilePicturePlaceholder.insertAdjacentHTML('beforeend', card);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        fetchRequest();
    });
</script>