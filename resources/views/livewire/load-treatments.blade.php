<div>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <div class="mt-10 p-4 rounded-lg flex flex-wrap justify-between mx-auto w-full dark:bg-gray-900 bg-primary-50">
        @foreach ($treatments->take(6) as $index => $treatment)
        <a href="{{ url('/treatments/' . $treatment->id) }}">
            <div class="relative overflow-hidden hidden md:block dark:border border-2 bg-green-200 dark:bg-green-100 border-green-200 dark:border-green-100 justify-between h-[14rem] w-[20rem] m-2 text-wrap rounded-md backdrop-blur-md"
            style="{{ $index >= 3 ? '' : 'display: block;' }}">
                <p class="absolute z-10 backdrop-blur-xl bg-green-100/50 rounded-lg w-full text-primary-600 font-bold text-xl dark:text-primary-400"> {{ optional($treatment)->name ?? 'Name Invalid' }}</p>
                <img class="absolute object-cover w-full h-full rounded-lg" src="{{ optional($treatment)->image ?? 'uploads/landing3.png'}}" alt="{{optional($treatment)->name ?? 'Name Invalid'}}">
                <p class="absolute bottom-0 z-10 w-full p-1 backdrop-blur-lg text-gray-900 dark:text-gray-800">
                    {{ optional($treatment)->description ?? 'No description added yet' }}</p>
            </div>
        </a>
        @endforeach
    </div>
    <div class="text-end">
        <a class="font-fira dark:text-primary-400 text-primary-600" href="{{ url('/treatments') }}">See all treatments</a>
    </div>

</div>
