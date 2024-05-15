<x-Layouts.printable>
    <div>
        <div class="relative">
            <div>
                <div class="absolute top left">
                    Patient Name: {{ $patient->name }}
                </div>
                <div class="absolute top right">
                    Date: {{ $appointment->appointment_date }}
                </div>

            </div>
            <table class="table">
                <tr>
                    <th>Treatment</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
                @foreach ($treatments as $treatment)
                    <tr>
                        <td>{{ $treatment->treatment->name }}</td>
                        <td>{{ $treatment->quantity }}</td>
                        <td>{{ $treatment->price }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="relative total">
            <div>
                Total Cost: {{ $appointment->calculated_fee }}
            </div>
            <div>
                Discount: {{ $appointment->discount }}
    
            </div>
            <div>
                Final Cost: {{ $appointment->total_fee }}
            </div>
        </div>
        

        <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    </div>
</x-Layouts.printable>
