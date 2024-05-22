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
                    <div class="absolute z-10 md:top-20 overflow-hidden">
                        <img class="w-full h-full object-cover" src="{{ optional($homeasset)->image ?? 'Home/big.png' }}"
                            alt="{{ 'toothfairyPic' }}">
                        <div
                            class="absolute z-20 bottom-0 rounded-lg left-0 right-0 mx-auto backdrop-blur-md overflow-hidden">
                            <a href="{{ url('/register') }}">
                                <p
                                    class="text-center px-2 mb-1 md:text-xl md:font-bold dark:text-fuchsia-300 text-fuchsia-200">
                                    {{ optional($homeasset)->p ?? 'Join Us Now' }}</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute left-5 right-5 mx-auto bottom-[-60rem] md:bottom-[-40rem]">
        <div class="mx-auto">
            <div class="flex flex-col md:flex-row gap-2">
                <div class="Img_database rounded-lg dark:bg-gray-800 bg-teal-100" style="border:0;">
                    <!-- image here -->
                    <img src="{{ optional($about_image)->image }}" alt="{{ optional($about_image)->name }}">
                </div>
                <div style="border-left: 0.25rem solid rgb(254 205 211 / 1);">
                </div>
                <div class="flex flex-col gap-2">
                    <div class="content_database rounded-lg dark:bg-gray-800 bg-teal-100 text-gray-900 dark:text-rose-300">
                        {!! $about_content->content !!}

                    </div>
                    <!--  a bullet list for social links -->
                    <div class=" social_database rounded-lg flex flex-col gap-3 dark:bg-gray-800 bg-teal-100">
                        @foreach ($social_links as $link)
                            <div class="flex flex-row gap-3">
                                <!-- check link has icon or not first -->
                                @svg($link->icon, 'h-6 w-6 text-rose-600 dark:text-rose-500')
                                <a class="font-fira text-rose-600 dark:text-rose-500" href="{{ $link->link }}"
                                    target="_blank">{{ $link->name }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
