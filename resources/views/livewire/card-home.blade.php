<div>
    <div class="relative h-64">
        
        <div class=" absolute z-10 bottom-0 p-2 rounded-tr-lg backdrop-blur-lg md:backdrop-blur-xl">
            <div class="text-6xl text-primary-600 dark:text-primary-400 font-postserif">
                {{ optional($homeasset)->h1 ?? 'Tooth Fairy Clinic' }}
            </div>
            <div class="relative">
                <p class="text-xl font-semibold pl-2 pb-4 text-orange-500">
                    {{ optional($homeasset)->h2 ?? 'One of the best Clinic in the Region.' }}
                    </p>
                <a class="text-rose-600 font-semibold absolute right-10 bottom-0" href="{{ url('/appointments/create') }}">
                    {{ optional($homeasset)->p ?? 'Appointment Now' }}
                    <span class="font-fira">---></span></a>
            </div>
        </div>
        <div class="w-16 h-16 md:h-64 md:w-64 absolute right-0 md:right-24 overflow-hidden z-0">
            <img src="{{ optional($homeasset)->image2 ?? 'uploads/small.png' }}" alt="landing logo"
                style="width: 100%; height: 100%; object-fit: cover; object-position:top">
        </div>
        <div class="absoulute left-0 overflow-hidden h-64">
            <img src="{{ optional($homeasset)->image ?? 'uploads/big.png' }}" alt="landing picture"
                style="width: 100%; height: 100%; object-fit: cover; object-position:top">
        </div>
    </div>

</div>
