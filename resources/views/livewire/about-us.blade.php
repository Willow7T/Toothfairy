<div class="mx-auto">
    <div class="flex flex-col md:flex-row gap-2">
        <div class="Img_database rounded-lg dark:bg-gray-900 bg-primary-50" style="border:0;">
            <!-- image here -->
            <img src="{{ optional($about_image)->image }}" alt="{{ optional($about_image)->name }}">
        </div>
        <div style="border-right: 0.25rem solid rgba(var(--primary-400), var(--tw-bg-opacity));">
          
        </div>
        <div class="flex flex-col gap-2">
            <div class="content_database rounded-lg dark:bg-gray-900 bg-primary-50">
                {!! $about_content->content !!}
            </div>
            <!--  a bullet list for social links -->
            <div class=" social_database rounded-lg flex flex-col gap-3 dark:bg-gray-900 bg-primary-50">
                @foreach ($social_links as $link)
                    <div class="flex flex-row gap-3">
                        <!-- check link has icon or not first -->
                        @svg($link->icon, 'h-6 w-6 text-primary-600 dark:text-primary-500')
                        <a class="font-fira text-primary-600 dark:text-primary-500" href="{{ $link->link }}"
                            target="_blank">{{ $link->name }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
