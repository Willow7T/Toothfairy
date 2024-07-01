<x-Layouts.printable>
    <div>
        <div class="relative">
            <div>
                <div class="absolute top left">
                    Patient Name: {{ $patient->name }}
                </div>
                <div class="absolute top-2 left">
                    Patient Age: {{ $patient->userbio->age }}
                </div>
                <div class="absolute top right">
                    Date: {{ $formattedDate }}
                </div>
                <div class="absolute top-2 right">
                    Status: {{ $appointment->status }}
                </div>

            </div>
            <table class="table">
                <tr>
                    <th>Treatment</th>
                    <th>Quantity</th>
                    <th>Price/Per Item</th>
                    <th>Total Price</th>
                </tr>
                @foreach ($treatments as $treatment)
                    <tr>
                        <td>{{ $treatment->treatment->name }}</td>
                        <td>{{ $treatment->quantity }}</td>
                        <td>{{ $treatment->price }}</td>
                        <td>{{ $treatment->quantity * $treatment->price }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="relative total">
            <p>
                Remarks: {{ $appointment->description }}
            </p>
            <div>
                Total Cost: {{ $appointment->calculated_fee }}
            </div>
            <div>
                Discount: {{ $appointment->discount_percentage . '% + ' . $appointment->discount }}
            </div>
            <div>
                Final Cost: {{ $appointment->total_fee }}
            </div>

        </div>


        <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    </div>

</x-Layouts.printable>
