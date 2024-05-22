<div
>
    <!-- Display the first card at the top with text centered -->
    @if ($cards->isNotEmpty())
        <div class="rounded-lg w-full mx-auto">
            <div class="relative">
                <div
                    class="rounded-lg absolute left-0 right-0 md:mx-auto md:w-4/12 top-24 p-4 text-center backdrop-blur-sm uppercase z-10 
                tracking-wide text-2xl text-primary-600 dark:text-primary-400 font-extrabold">
                    {{ $cards->first()->title }}</div>
                <div class="absoulute rounded-lg left-0 overflow-hidden">
                    <img class=" w-full object-fill rounded-lg z-0 h-[25rem]" src="{{ $cards->first()->image }}" alt="Card image">
                </div>

                <p class="absolute p-1 text-center w-full rounded-b-lg bottom-0 mt-2 z-10 bg-gray-50 text-gray-600"
                    style="background-color: rgba(var(--primary-50), 0.6);">{{ $cards->first()->content }}</p>

            </div>
        </div>
    @endif
    <!-- Display the rest of the cards -->
    @foreach ($cards->skip(1) as $index => $card)
        <div class="pt-6 rounded-lg mx-10">
            <div class="md:flex md:justify-between {{ $index % 2 == 0 ? 'md:flex-row-reverse' : '' }}">
                <div
                    class="md:flex-shrink-0 rounded-t-lg md:rounded-lg text-center  md:w-5/12 md:h-60"style="background-color: rgba(var(--primary-50), var(--tw-bg-opacity));">
                    <img class="rounded-t-lg md:rounded-none h-full w-full object-fill md:w-80 md:mx-auto" src="{{ $card->image }}"
                        alt="Card image">
                </div>
                <div class="p-8 text-wrap md:w-5/12 rounded-b-lg md:rounded-lg md:h-60"
                    style="background-color: rgba(var(--primary-50), var(--tw-bg-opacity));">
                    <div class="uppercase tracking-wide text-sm text-primary-600 dark:text-primary-400 font-semibold">
                        {{ $card->title }}</div>
                    <p class="mt-2 text-gray-600  dark:text-gray-500">{{ $card->content }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
