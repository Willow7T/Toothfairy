<div>
    <!-- Display the first card at the top with text centered -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if($cards->isNotEmpty())
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl m-3">
            <div class="md:flex">
                <div class="md:flex-shrink-0">
                    <img class="h-48 w-full object-cover md:w-48" src="{{ $cards->first()->image }}" alt="Card image">
                </div>
                <div class="p-8">
                    <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">{{ $cards->first()->title }}</div>
                    <p class="mt-2 text-gray-500">{{ $cards->first()->content }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Display the rest of the cards -->
    @foreach($cards->skip(1) as $index => $card)
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl m-3">
            <div class="md:flex {{ $index % 2 == 0 ? 'md:flex-row-reverse' : '' }}">
                <div class="md:flex-shrink-0">
                    <img class="h-48 w-full object-cover md:w-48" src="{{ $card->image }}" alt="Card image">
                </div>
                <div class="p-8">
                    <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">{{ $card->title }}</div>
                    <p class="mt-2 text-gray-500">{{ $card->content }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
    <!-- Display the first card at the top with text centered -->
