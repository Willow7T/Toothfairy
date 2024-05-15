<div>
        <div>
            {{ $patient->name }}
        </div>
        @foreach ($treatments as $treatment)
            
            <p>{{$treatment->treatment->name}}</p>
            <p>{{ $treatment->price }}</p>
        @endforeach
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
</div>
