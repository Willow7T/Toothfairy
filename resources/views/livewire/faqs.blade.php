<div>
    <div class="relative ">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <div class="text-4xl text-center mt-4 text-yellow-300 font-postserif">
            Frequently Asked Questions
        </div>
        @foreach ($faqs as $faq)
            <div class="flex justify-center mt-4">
                <div class="w-1/2">
                    <div class="text-xl border-gray-300 border-b ">
                    <span class="text-yellow-100 font-postserif">Q: </span> {{ $faq->question }}
                    </div>
                    <div class="text-md text-white ">
                        <span class="text-green-200 font-postserif">A: </span> {{ $faq->answer }}
                    </div>
                </div>
            </div>            
        @endforeach
    </div>

</div>
