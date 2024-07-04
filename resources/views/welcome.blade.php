<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ url('uploads/Favicon.png') }}">
    <title>ToothFairy</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        @import"https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap";
        @import"https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&family=Poetsen+One&display=swap";

        *,
        :before,
        :after {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb
        }

        :before,
        :after {
            --tw-content: ""
        }

        html,
        :host {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            -o-tab-size: 4;
            tab-size: 4;
            font-family: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", Segoe UI Symbol, "Noto Color Emoji";
            font-feature-settings: normal;
            font-variation-settings: normal;
            -webkit-tap-highlight-color: transparent
        }

        body {
            margin: 0;
            line-height: inherit
        }

        hr {
            height: 0;
            color: inherit;
            border-top-width: 1px
        }

        abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        b,
        strong {
            font-weight: bolder
        }

        code,
        kbd,
        samp,
        pre {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, Liberation Mono, Courier New, monospace;
            font-feature-settings: normal;
            font-variation-settings: normal;
            font-size: 1em
        }

        small {
            font-size: 80%
        }

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sub {
            bottom: -.25em
        }

        sup {
            top: -.5em
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            font-feature-settings: inherit;
            font-variation-settings: inherit;
            font-size: 100%;
            font-weight: inherit;
            line-height: inherit;
            letter-spacing: inherit;
            color: inherit;
            margin: 0;
            padding: 0
        }

        button,
        select {
            text-transform: none
        }

        button,
        input:where([type=button]),
        input:where([type=reset]),
        input:where([type=submit]) {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none
        }

        :-moz-focusring {
            outline: auto
        }

        :-moz-ui-invalid {
            box-shadow: none
        }

        progress {
            vertical-align: baseline
        }

        ::-webkit-inner-spin-button,
        ::-webkit-outer-spin-button {
            height: auto
        }

        [type=search] {
            -webkit-appearance: textfield;
            outline-offset: -2px
        }

        ::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        summary {
            display: list-item
        }

        blockquote,
        dl,
        dd,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        hr,
        figure,
        p,
        pre {
            margin: 0
        }

        fieldset {
            margin: 0;
            padding: 0
        }

        legend {
            padding: 0
        }

        ol,
        ul,
        menu {
            list-style: none;
            margin: 0;
            padding: 0
        }

        dialog {
            padding: 0
        }

        textarea {
            resize: vertical
        }

        input::-moz-placeholder,
        textarea::-moz-placeholder {
            opacity: 1;
            color: #9ca3af
        }

        input::placeholder,
        textarea::placeholder {
            opacity: 1;
            color: #9ca3af
        }

        button,
        [role=button] {
            cursor: pointer
        }

        :disabled {
            cursor: default
        }

        img,
        svg,
        video,
        canvas,
        audio,
        iframe,
        embed,
        object {
            display: block;
            vertical-align: middle
        }

        img,
        video {
            max-width: 100%;
            height: auto
        }

        [hidden] {
            display: none
        }



        *,
        :before,
        :after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / .5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
            --tw-contain-size: ;
            --tw-contain-layout: ;
            --tw-contain-paint: ;
            --tw-contain-style:
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / .5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
            --tw-contain-size: ;
            --tw-contain-layout: ;
            --tw-contain-paint: ;
            --tw-contain-style:
        }

        .absolute {
            position: absolute
        }

        .relative {
            position: relative
        }

        .bottom-0 {
            bottom: 0
        }

        .bottom-\[-60rem\] {
            bottom: -60rem
        }

        .left-0 {
            left: 0
        }

        .left-5 {
            left: 1.25rem
        }

        .left-6 {
            left: 1.5rem
        }

        .left-14 {
            left: 3.5rem;
        }

        .left-\[12\%\] {
            left: 12%;
        }

        .right-0 {
            right: 0
        }

        .right-5 {
            right: 1.25rem
        }

        .right-6 {
            right: 1.5rem
        }

        .right-\[10\%\] {
            right: 10%;
        }

        .top-20 {
            top: 5rem
        }

        .top-\[40\%\] {
            top: 40%;
        }

        .z-10 {
            z-index: 10
        }

        .z-20 {
            z-index: 20
        }

        .z-30 {
            z-index: 30;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .mb-1 {
            margin-bottom: .25rem
        }

        .mb-2 {
            margin-bottom: .5rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .flex {
            display: flex
        }

        .h-6 {
            height: 1.5rem
        }

        .h-full {
            height: 100%
        }

        .w-6 {
            width: 1.5rem
        }

        .w-full {
            width: 100%
        }

        .flex-row {
            flex-direction: row
        }

        .flex-col {
            flex-direction: column
        }

        .gap-2 {
            gap: .5rem
        }

        .gap-3 {
            gap: .75rem
        }

        .overflow-hidden {
            overflow: hidden
        }

        .rounded-lg {
            border-radius: .5rem
        }

        .bg-gray-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(249 250 251 / var(--tw-bg-opacity))
        }

        .bg-teal-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(204 251 241 / var(--tw-bg-opacity))
        }

        .object-cover {
            -o-object-fit: cover;
            object-fit: cover
        }

        .p-4 {
            padding: 1rem
        }

        .px-2 {
            padding-left: .5rem;
            padding-right: .5rem
        }

        .text-center {
            text-align: center
        }

        .text-right {
            text-align: right
        }

        .font-fira {
            font-family: Fira Code, monospace
        }

        .font-postserif {
            font-family: Poetsen One, sans-serif
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem
        }

        .text-sm {
            font-size: .875rem;
            line-height: 1.25rem
        }

        .font-semibold {
            font-weight: 600
        }

        .text-fuchsia-200 {
            --tw-text-opacity: 1;
            color: rgb(245 208 254 / var(--tw-text-opacity))
        }

        .text-gray-600 {
            --tw-text-opacity: 1;
            color: rgb(75 85 99 / var(--tw-text-opacity))
        }

        .text-gray-900 {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity))
        }

        .text-rose-500 {
            --tw-text-opacity: 1;
            color: rgb(244 63 94 / var(--tw-text-opacity))
        }

        .text-rose-600 {
            --tw-text-opacity: 1;
            color: rgb(225 29 72 / var(--tw-text-opacity))
        }

        .text-teal-500 {
            --tw-text-opacity: 1;
            color: rgb(20 184 166 / var(--tw-text-opacity))
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .backdrop-blur-md {
            --tw-backdrop-blur: blur(12px);
            -webkit-backdrop-filter: var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);
            backdrop-filter: var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)
        }

        .content_database a {
            --tw-text-opacity: 1;
            color: rgb(94 234 212/ var(--tw-text-opacity))
        }

        .content_database ul {
            list-style-type: disc
        }

        .content_database ol {
            list-style-type: decimal
        }

        .content_database h2 {
            font-size: 1.5rem;
            font-weight: 600;
            line-height: 2rem;
            margin-top: 1rem;
            margin-bottom: 1rem
        }

        .content_database h3 {
            font-size: 1.25rem;
            font-weight: 600;
            line-height: 1.75rem;
            margin-top: 1rem;
            margin-bottom: 1rem
        }

        .content_database blockquote {
            max-width: 90%;
            padding: .2rem;
            /* italic */
            font-style: italic;
            --tw-bg-opacity: 1;
            --tw-text-opacity: 1;
            --tw-border-opacity: 1;
            color: rgb(254 205 211 / var(--tw-text-opacity));
            background-color: rgb(8 145 178 / var(--tw-bg-opacity));
            border-left: .25rem solid rgb(254 205 211 / var(--tw-border-opacity));
            border-radius: .375rem
        }

        .content_database,
        .social_database {
            width: 20rem;
            height: 30rem;
            padding: 1rem
        }

        .Img_database {
            width: 20rem;
            height: 20rem;
            overflow: hidden
        }

        .Img_database img {
            width: 90%;
            height: 90%;
            padding-top: 2rem;
            margin: auto;
            -o-object-fit: cover;
            object-fit: cover
        }

        @media (min-width: 768px) {

            .content_database,
            .social_database {
                width: 35rem;
                height: 20rem
            }

            .Img_database {
                width: 40rem;
                height: 40rem
            }
        }

        .hover\:text-gray-900:hover {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity))
        }

        .focus\:rounded-sm:focus {
            border-radius: .125rem
        }

        .focus\:outline:focus {
            outline-style: solid
        }

        .focus\:outline-2:focus {
            outline-width: 2px
        }

        @media (min-width: 430px) {
            .min-\[430px\]\:bottom-\[-45rem\] {
                bottom: -45rem;
            }
        }

        @media (min-width: 640px) {
            .sm\:fixed {
                position: fixed
            }

            .sm\:right-0 {
                right: 0
            }

            .sm\:top-0 {
                top: 0
            }

            .sm\:top-\[100\%\] {
                top: 100%;
            }
        }

        @media (min-width: 768px) {
            .md\:bottom-\[-40rem\] {
                bottom: -40rem
            }

            .md\:left-5 {
                left: 1.25rem;
            }

            .md\:right-5 {
                right: 1.25rem;
            }

            .md\:top-\[60\%\] {
                top: 60%;
            }

            .md\:left-20 {
                left: 5rem
            }

            .md\:right-20 {
                right: 5rem
            }

            .md\:top-20 {
                top: 5rem
            }

            .md\:top-60 {
                top: 15rem
            }

            .md\:mx-auto {
                margin-left: auto;
                margin-right: auto
            }

            .md\:max-w-7xl {
                max-width: 80rem
            }

            .md\:flex-row {
                flex-direction: row
            }

            .md\:text-6xl {
                font-size: 3.75rem;
                line-height: 1
            }

            .md\:col-span-2 {
                grid-column: span 2 / span 2;
            }

            .md\:text-lg {
                font-size: 1.125rem;
                line-height: 1.75rem
            }

            .md\:text-xl {
                font-size: 1.25rem;
                line-height: 1.75rem
            }

            .md\:font-bold {
                font-weight: 700
            }
        }



        @media (min-width: 1024px) {
            .lg\:p-8 {
                padding: 2rem
            }
        }

        .dark\:bg-gray-900:where(.dark, .dark *) {
            --tw-bg-opacity: 1;
            background-color: rgb(17 24 39 / var(--tw-bg-opacity))
        }

        .dark\:bg-gray-800:where(.dark, .dark *) {
            --tw-bg-opacity: 1;
            background-color: rgb(31 41 55 / var(--tw-bg-opacity))
        }


        .dark\:text-fuchsia-300:where(.dark, .dark *) {
            --tw-text-opacity: 1;
            color: rgb(240 171 252 / var(--tw-text-opacity))
        }

        .dark\:text-gray-400:where(.dark, .dark *) {
            --tw-text-opacity: 1;
            color: rgb(156 163 175 / var(--tw-text-opacity))
        }

        .dark\:text-gray-50:where(.dark, .dark *) {
            --tw-text-opacity: 1;
            color: rgb(249 250 251 / var(--tw-text-opacity))
        }

        .dark\:text-rose-300:where(.dark, .dark *) {
            --tw-text-opacity: 1;
            color: rgb(253 164 175 / var(--tw-text-opacity))
        }


        .dark\:text-rose-500:where(.dark, .dark *) {
            --tw-text-opacity: 1;
            color: rgb(244 63 94 / var(--tw-text-opacity))
        }

        .dark\:text-rose-300:where(.dark, .dark *) {
            --tw-text-opacity: 1;
            color: rgb(253 164 175 / var(--tw-text-opacity))
        }

        .dark\:text-teal-300:where(.dark, .dark *) {
            --tw-text-opacity: 1;
            color: rgb(94 234 212 / var(--tw-text-opacity))
        }

        .dark\:hover\:text-white:hover:where(.dark, .dark *) {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        @media (min-width: 1280px) {
            .xl\:bottom-\[-55rem\] {
                bottom: -42rem;
            }

            .xl\:left-28 {
                left: 7rem;
            }
        }
    </style>
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-900">
    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-30">
        <a href="#about-us"
            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm  p-1">About
            Us</a>
        @auth
            <a href="{{ url('/home') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm  p-1">Home</a>
            @if (auth()->user()->role_id === 1)
                <a href="{{ url('/admin') }}"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm ">Admin</a>
            @endif
            @if (auth()->user()->role_id === 2)
                <a href="{{ url('/dentist') }}"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm ">Dentist</a>
            @endif
        @else
            <a href="{{ url('/login') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm  p-1">Log
                in</a>
            <a href="{{ url('/register') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm ">Register</a>
        @endauth
    </div>

    <livewire:Welcome />
</body>
<script>
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.body.classList.add('dark');
    }
</script>

</html>
