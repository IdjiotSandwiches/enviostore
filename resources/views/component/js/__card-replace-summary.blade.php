<script>
    function renderEmptyCart() {
        let container = document.querySelector('#container');
        container.replaceChildren();

        let item = `{!! view('component.__empty-card')->render() !!}`;
        container.insertAdjacentHTML('beforeend', item);
    }

    function showSkeleton() {
        emptyContent();

        setTimeout(function() {
            if(checkPlaceholder(cartContainer) && checkPlaceholder(summaryContainer)) return;

            let cart = `{!! view('component.__skeleton-item')->render() !!}`;
            cartContainer.insertAdjacentHTML('beforeend', cart);

            let item = `{!! view('component.__skeleton-summary')->render() !!}`;
            summaryContainer.insertAdjacentHTML('beforeend', item);
        },200);
    }

    function fetchRequest(url) {
        showSkeleton();
        customFetch(url, {
            method: 'GET',
        }).then(response => {
            emptyContent();
            replaceContent(response);
        });
    }

    function insertCard(items) {
        items.forEach(item => {
            let card = `{!! view('component.__item-card', [
                'link' => '::LINK::',
                'image' => '::IMAGE::',
                'name' => '::NAME::',
                'price' => '::PRICE::',
                'quantity' => '::QUANTITY::',
                'category' => '::CATEGORY::',
                'delete' => '::DELETE::',
            ])->render() !!}`;

            card = card.replace('::LINK::', item.link)
                .replace('::IMAGE::', item.img)
                .replaceAll('::NAME::', item.productName)
                .replace('::PRICE::', item.price)
                .replace('::QUANTITY::', item.quantity)
                .replace('::CATEGORY::', item.categoryName)
                .replace('::DELETE::', item.delete);

            card = item.isAvailable ? 
                card.replaceAll('::OPACITY::', '')
                    .replace('::HIDDEN::', 'hidden') : 
                card.replaceAll('::OPACITY::', 'opacity-30')
                    .replace('::HIDDEN::', '');
            
            cartContainer.insertAdjacentHTML('beforeend', card);
        });
    }

    function emptyContent() {
        cartContainer.replaceChildren();
        summaryContainer.replaceChildren();
    }
</script>