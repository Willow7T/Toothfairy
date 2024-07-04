<div>
    <div class=" relative md:max-w-7xl md:mx-auto lg:p-8">
        {{-- <livewire:Welcome /> --}}
        <div>
            <div class="relative">
                <div class="relative">
                    <div
                        class="absolute z-20 top-20 md:top-60 left-6 right-6 rounded-lg md:left-20 md:right-20 mx-auto backdrop-blur-md overflow-hidden">
                        <p
                            class="text-center px-2 relative text-2xl md:text-6xl text-rose-500 dark:text-rose-300 font-postserif">
                            {{ optional($homeasset)->h1 ?? 'Tooth Fairy Clinic' }}</p>
                        <p
                            class="text-center px-2 mb-2 text-sm md:text-lg relative text-teal-500 dark:text-teal-300 font-postserif">
                            {{ optional($homeasset)->h2 ?? 'One of the Best Clinic in Region' }}</p>
                    </div>
                </div>
                <div class="relative">
                    <div class="md:top-20 overflow-hidden">
                        <img class="w-full h-full object-cover"
                            src="{{ optional($homeasset)->image ?? 'uploads/big.png' }}" alt="{{ 'toothfairyPic' }}">
                        <div
                            class="absolute z-20 bottom-0 rounded-lg left-0 right-0 mx-auto backdrop-blur-md overflow-hidden">
                            @auth
                                @if (auth()->user()->role_id === 3)
                                    @if (auth()->user()->appointmentswpatient->count() > 0)
                                        <a href="{{ url('/appointments') }}">
                                            <p
                                                class="text-center px-2 mb-1 md:text-xl md:font-bold dark:text-fuchsia-300 text-fuchsia-200">
                                                {{ optional($homeasset)->p ?? 'Join Us Now' }}</p>
                                        </a>
                                    @else
                                        <a href="{{ url('/appointments/create') }}">
                                            <p
                                                class="text-center px-2 mb-1 md:text-xl md:font-bold dark:text-fuchsia-300 text-fuchsia-200">
                                                {{ optional($homeasset)->p ?? 'Join Us Now' }}</p>
                                        </a>
                                    @endif
                                @endif
                            @else
                                <a href="{{ url('/login') }}">
                                    <p
                                        class="text-center px-2 mb-1 md:text-xl md:font-bold dark:text-fuchsia-300 text-fuchsia-200">
                                        {{ optional($homeasset)->p ?? 'Join Us Now' }}</p>
                                </a>
                            @endauth

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="about-us" class="mx-auto p-4" style="max-width: fit-content">
        <div class="mx-auto">
            <div class="flex flex-col md:flex-row gap-2">
                <div class="Img_database rounded-lg dark:bg-gray-800 bg-teal-100" style="border:0;">
                    <img src="{{ optional($about_image)->image ?? 'uploads/big.png' }}"
                        alt="{{ optional($about_image)->name ?? 'About Us' }}">
                </div>
                <div style="border-left: 0.25rem solid rgb(254 205 211 / 1);">
                </div>
                <div class="flex flex-col gap-2">
                    <div
                        class="content_database rounded-lg dark:bg-gray-800 bg-teal-100 text-gray-900 dark:text-rose-300">
                        {!! optional($about_content)->content ??
                            '<h2>Under Renovation</h2><p>The site management team has taken down this section to make a fresh experience for users.</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <blockquote>This section is under renovation</blockquote>' !!}
                    </div>
                    <!--  a bullet list for social links -->
                    <div class=" social_database rounded-lg flex flex-col gap-3 dark:bg-gray-800 bg-teal-100">
                        @if ($social_links)
                            @foreach ($social_links as $link)
                                <div class="flex flex-row gap-3">
                                    @safeSvgW(optional($link)->icon ?? 'fab-facebook', 'h-6 w-6 text-rose-600 dark:text-rose-500')
                                    <a class="font-fira text-rose-600 dark:text-rose-500"
                                        href="{{ optional($link)->link ?? 'https://facebook.com/' }}"
                                        target="_blank">{{ optional($link)->name ?? 'toothfairyadmin@facebook' }}</a>
                                </div>
                            @endforeach
                        @else
                            <div class="flex flex-row gap-3">
                                @safeSvgW('fab-facebook', 'h-6 w-6 text-rose-600 dark:text-rose-500')
                                <a class="font-fira text-rose-600 dark:text-rose-500" href="https://facebook.com/"
                                    target="_blank">toothfairyadmin@facebook</a>
                            </div>
                            <div class="flex flex-row gap-3">
                                @safeSvgW('fab-x-twitter', 'h-6 w-6 text-rose-600 dark:text-rose-500')
                                <a class="font-fira text-rose-600 dark:text-rose-500" href="https://x.com/"
                                    target="_blank">toothfairyadmin@x</a>
                            </div>
                            <div class="flex flex-row gap-3">
                                @safeSvgW('fab-instagram', 'h-6 w-6 text-rose-600 dark:text-rose-500')
                                <a class="font-fira text-rose-600 dark:text-rose-500" href="https://instagram.com/"
                                    target="_blank">toothfairyadmin@instagram</a>
                            </div>
                            <div class="flex flex-row gap-3">
                                @safeSvgW('fab-linkedin-in', 'h-6 w-6 text-rose-600 dark:text-rose-500')
                                <a class="font-fira text-rose-600 dark:text-rose-500" href="https://linkedin.com/"
                                    target="_blank">toothfairyadmin@linkedin</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
