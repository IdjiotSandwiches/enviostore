<script>
    const profilePicturePlaceholder = document.querySelector('#profile-picture-placeholder');

    function fetchRequest() {
        let url = '{{ route('profile.getProfilePicture') }}';
        profilePicturePlaceholder.replaceChildren();

        setTimeout(function() {
            if(checkEmptyPlaceholder(profilePicturePlaceholder)) return;

            let card = `{!! view('component.__profile-skeleton')->render() !!}`;
            profilePicturePlaceholder.insertAdjacentHTML('beforeend', card);
        },200);

        customFetch(url, {
            method: 'GET',
        }).then(response => {
            if(!response.ok) {
                throw new Error();
            }
            
            profilePicturePlaceholder.replaceChildren();
            return response.json();
        }).then(response => {
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