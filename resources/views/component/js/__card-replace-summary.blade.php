<script>
    let totalPrice = null;
    
    function fetchRequest(url) {
        emptyContent();

        setTimeout(function() {
            if(cartContainer.textContent !== '' && summaryContainer.textContent !== '') return;

            let cart = `{!! view('component.__skeleton-item')->render() !!}`;
            cartContainer.insertAdjacentHTML('beforeend', cart);

            let item = `{!! view('component.__skeleton-summary')->render() !!}`;
            summaryContainer.insertAdjacentHTML('beforeend', item);
        },200);

        customFetch(url, {
            method: 'GET',
        }).then(response => {
            if(!response.ok) {
                throw new Error();
            }

            emptyContent();
            return response.json();
        }).then(response => {
            replaceContent(response);
            radioInputListener();
        }).catch(error => {
            let section = document.querySelector('section');
            let item = `{!! view('component.__fetch-failed')->render() !!}`;
            
            section.replaceChildren();
            section.insertAdjacentHTML('beforeend', item);
        });
    }

    function replaceContent(response) {
        emptyContent();
        
        let items = response.data.items;
        if(items.length === 0) {
            let container = document.querySelector('#container');
            container.replaceChildren();

            let item = `{!! view('component.__empty-card')->render() !!}`;
            container.insertAdjacentHTML('beforeend', item);

            return;
        }
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
            
            cartContainer.insertAdjacentHTML('beforeend', card);
        });

        let summary = response.data.summary;
        @if (request()->routeIs('cart.index'))
            let card = `{!! view('cart.component.__summary-card', [
                'subtotal' => '::SUBTOTAL::',
                'quantity' => '::QUANTITY::',
            ])->render() !!}`;

            card = card.replace('::SUBTOTAL::', summary.subtotal ?? '-')
                .replace('::QUANTITY::', summary.quantity ?? '-');
        @else
            let card = `{!! view('checkout.component.__summary-card', [
                'subtotal' => '::SUBTOTAL::',
                'quantity' => '::QUANTITY::',
                'transaction' => '::TRANSACTION::',
                'shipping' => '::SHIPPING::',
                'total' => '::TOTAL::'
            ])->render() !!}`;

            card = card.replace('::SUBTOTAL::', summary.subtotal ?? '-')
                .replace('::QUANTITY::', summary.quantity ?? '-')
                .replace('::TRANSACTION::', summary.adminFee ?? '-')
                .replace('::SHIPPING::', summary.shippingFee ?? '-')
                .replace('::TOTAL::', summary.total ?? '-');

            totalPrice = parseFloat(summary.total.replaceAll('.', ''));
        @endif
        
        summaryContainer.insertAdjacentHTML('beforeend', card);
        
        let shippingRadio = `{!! view('checkout.component.__shipping', ['shippings' => $shippings])->render() !!}`;
        shippingContainer.insertAdjacentHTML('beforeend', shippingRadio);
    }

    function emptyContent() {
        cartContainer.replaceChildren();
        summaryContainer.replaceChildren();
    }
</script>