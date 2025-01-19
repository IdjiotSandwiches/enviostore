@extends('layout.layout')
@section('title', __('title.dashboard'))

@section('content')
    <section class="max-w-screen-xl px-4 py-8 md:mx-auto grid gap-4">
        <h1 class="text-3xl">{{ __('header.welcome') }} <span class="font-bold">Admin</span></h1>
        <div class="p-6 bg-primary rounded-lg shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="flex items-center">
                    <div class="flex flex-col items-center text-center">
                        <div class="text-font_primary text-lg mb-2">Total Sales</div>
                        <div class="p-3 rounded-lg">
                            <svg width="51" height="45" viewBox="0 0 51 45" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.916992 44.625V39.7083H50.0837V44.625H0.916992ZM3.37533 37.25V20.0417H10.7503V37.25H3.37533ZM15.667 37.25V7.75H23.042V37.25H15.667ZM27.9587 37.25V15.125H35.3337V37.25H27.9587ZM40.2503 37.25V0.375H47.6253V37.25H40.2503Z"
                                    fill="#2C2C2C" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-6 mt-8">
                        <p class="text-3xl font-bold text-gray-900">$12,345</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex flex-col items-center text-center">
                        <div class="text-font_primary text-lg mb-2">Total Order Field</div>
                        <div class="p-3 rounded-lg">
                            <svg width="46" height="46" viewBox="0 0 46 46" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M33.7034 39.7414L40.6851 32.8679L39.1461 31.3265L33.7034 36.6931L31.3557 34.2962L29.8143 35.8499L33.7034 39.7414ZM7.64259 12.4637H33.3617V10.0054H7.64013L7.64259 12.4637ZM35.2497 45.3685C32.5111 45.3685 30.188 44.4139 28.2803 42.5046C26.371 40.5969 25.4163 38.2738 25.4163 35.5352C25.4163 32.7966 26.371 30.4727 28.2803 28.5634C30.1896 26.6541 32.5127 25.7002 35.2497 25.7019C37.9866 25.7035 40.3106 26.6573 42.2215 28.5634C44.1325 30.4694 45.0863 32.7933 45.083 35.5352C45.083 38.2721 44.1292 40.5953 42.2215 42.5046C40.3106 44.4139 37.9866 45.3685 35.2497 45.3685ZM0.833008 42.0572V0.833374H40.1663V19.4184C38.7045 18.9382 37.2065 18.6915 35.6725 18.6784C34.1385 18.6653 32.6266 18.8628 31.1369 19.2709H7.64013V21.7292H25.6155C24.383 22.5831 23.2964 23.5852 22.3557 24.7357C21.415 25.8862 20.6398 27.1531 20.0301 28.5363H7.64259V30.9947H19.2213C19.0443 31.6568 18.9067 32.3246 18.8083 32.9982C18.71 33.6718 18.66 34.3749 18.6584 35.1075C18.6584 36.2301 18.7756 37.3437 19.0099 38.4483C19.2443 39.5529 19.5966 40.6174 20.067 41.6417L19.9834 41.7253L17.1932 39.6947L13.8843 42.0572L10.5754 39.6947L7.26647 42.0572L3.95509 39.6947L0.833008 42.0572Z"
                                    fill="#2C2C2C" />
                            </svg>
                        </div>  
                    </div>
                    <div class="ml-6 mt-8">
                        <p class="text-3xl font-bold text-gray-900">50</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex flex-col items-center text-center">
                        <div class="text-font_primary text-lg mb-2">New User This Month</div>
                        <div class="p-3 rounded-lg">
                            <svg width="41" height="41" viewBox="0 0 41 41" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20.4997 0.833374C23.1076 0.833374 25.6088 1.86938 27.4529 3.71349C29.297 5.5576 30.333 8.05874 30.333 10.6667C30.333 13.2747 29.297 15.7758 27.4529 17.6199C25.6088 19.464 23.1076 20.5 20.4997 20.5C17.8917 20.5 15.3906 19.464 13.5465 17.6199C11.7023 15.7758 10.6663 13.2747 10.6663 10.6667C10.6663 8.05874 11.7023 5.5576 13.5465 3.71349C15.3906 1.86938 17.8917 0.833374 20.4997 0.833374ZM20.4997 25.4167C31.3655 25.4167 40.1663 29.8171 40.1663 35.25V40.1667H0.833008V35.25C0.833008 29.8171 9.63384 25.4167 20.4997 25.4167Z"
                                    fill="#2C2C2C" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-6 mt-8">
                        <p class="text-3xl font-bold text-gray-900">1 </p>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
