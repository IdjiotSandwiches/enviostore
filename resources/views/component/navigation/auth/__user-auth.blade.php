@if (session(App\Interfaces\SessionKeyInterface::SESSION_IS_LOGGED_IN))
    <div class="flex items-center gap-2" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-end">
        <img id="avatarButton" type="button" class="block w-10 h-10 rounded-full cursor-pointer" aria-hidden="true" src="#"
            alt="User dropdown">
    </div>
    <div id="userDropdown" class="hidden z-10 bg-white divide-y divide-gray-200 rounded-lg shadow">
        @include('component.navigation.auth.__user-settings', ['link' => '#', 'text' => __('navbar.profile'), 'icon' => 'component.navigation.icon.__profile'])
        @include('component.navigation.auth.__user-settings', ['link' => route('logout'), 'text' => __('navbar.logout'), 'icon' => 'component.navigation.icon.__logout'])
    </div>
@else
    @include('component.navigation.__not-auth')
@endif