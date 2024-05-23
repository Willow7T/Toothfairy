<div class="mx-auto">
    <div class="flex flex-col md:flex-row gap-2">
        <div class="Img_database rounded-lg dark:bg-gray-900 bg-primary-50" style="border:0;">
            <!-- image here -->
            <img src="{{ optional($about_image)->image ?? 'uploads/big.png' }}"
                alt="{{ optional($about_image)->name ?? 'AboutusImg' }}">
        </div>
        <div style="border-right: 0.25rem solid rgba(var(--primary-400), var(--tw-bg-opacity));">

        </div>
        <div class="flex flex-col gap-2">
            <div class="content_database rounded-lg dark:bg-gray-900 bg-primary-50">
                {!! optional($about_content)->content ??
                    '<h2>Under Renovation</h2><p>The site management team has taken down this section to make a fresh experience for users.</p>
                                                <blockquote>This section is under renovation</blockquote>' !!}
            </div>
            <!--  a bullet list for social links -->
            <div class=" social_database rounded-lg flex flex-col gap-3 dark:bg-gray-900 bg-primary-50">
                @if ($social_links)
                    @foreach ($social_links as $link)
                        <div class="flex flex-row gap-3">
                            <!-- check link has icon or not first -->
                            
                            @safeSvg(optional($link)->icon ?? 'fab-facebook', 'h-6 w-6 text-primary-600 dark:text-primary-500')                            <a class="font-fira text-primary-600 dark:text-primary-500"
                                href="{{ optional($link)->link ?? '#' }}"
                                target="_blank">{{ optional($link)->name ?? 'admin@toothfairy' }}</a>
                        </div>
                    @endforeach
                @else
                    <div class="flex flex-row gap-3">
                        @safeSvg('fab-facebook', 'h-6 w-6 text-primary-600 dark:text-primary-500')
                        <a class="font-fira text-primary-600 dark:text-primary-500" href="https://facebook.com/"
                        target="_blank">toothfairyadmin@facebook</a>
                    </div>
                    <div class="flex flex-row gap-3">
                        @safeSvg('fab-twitter', 'h-6 w-6 text-primary-600 dark:text-primary-500')
                        <a class="font-fira text-primary-600 dark:text-primary-500" href="https://x.com/"
                        target="_blank">toothfairyadmin@x</a>
                    </div>
                    <div class="flex flex-row gap-3">
                        @safeSvg('fab-instagram', 'h-6 w-6 text-primary-600 dark:text-primary-500')
                        <a class="font-fira text-primary-600 dark:text-primary-500" href="https://instagram.com/"
                        target="_blank">toothfairyadmin@instgram</a>
                    </div>
                    <div class="flex flex-row gap-3">
                        @safeSvg('fab-linkedin', 'h-6 w-6 text-primary-600 dark:text-primary-500')
                        <a class="font-fira text-primary-600 dark:text-primary-500" href="https://linkedin.com/"
                        target="_blank">toothfairyadmin@linkedin</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
