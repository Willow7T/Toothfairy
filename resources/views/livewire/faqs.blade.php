<div>
    <div class="relative">
        <div class="pt-2 text-center text-primary-600 dark:text-primary-400 font-extrabold"
            style="font-size: 2.5rem;
    line-height: 2rem;">
            <h1>Frequently Asked Questions</h1>
        </div>
        @foreach ($faqs as $faq)
            <div class="flex justify-center mt-4">
                <div class="w-9/12">
                    <div class="text-xl text-gray-700 dark:text-gray-200 border-gray-300 border-b ">
                        <span class="text-yellow-400 dark:text-yellow-200 font-postserif">Q: </span>
                        {{ optional($faq)->question ?? 'Do you watch stars every night?' }}
                    </div>
                    <div class="text-md text-gray-600 dark:text-gray-400 ">
                        <span class="text-green-400 dark:text-green-200 font-postserif">A: </span>
                        {{ optional($faq)->answer ?? 'This is an easter egg faq for getting null value!' }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
