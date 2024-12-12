<div class="inline-flex items-center gap-2">
    @if (\Illuminate\Support\Facades\App::getLocale() === 'id')
        @include('component.navigation.locale.__ID')
    @elseif (\Illuminate\Support\Facades\App::getLocale() === 'en')
        @include('component.navigation.locale.__EN')
    @endif
</div>