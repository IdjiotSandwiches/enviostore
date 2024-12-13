<div class="inline-flex items-center gap-2">
    @if (\Illuminate\Support\Facades\App::isLocale(\App\Interfaces\LocaleInterface::ID))
        @include('component.navigation.locale.__ID')
    @else
        @include('component.navigation.locale.__EN')
    @endif
</div>