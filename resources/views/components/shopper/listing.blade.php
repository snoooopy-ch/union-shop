<x-table-column>
    <x-shopper.status :shopper="$shopper"/>
</x-table-column>

<x-table-column>
    {{ $shopper['first_name'] }} {{ $shopper['last_name'] }}
</x-table-column>

<x-table-column>
    {{ $shopper['email'] }}
</x-table-column>

<x-table-column>
    {{ $shopper['check_in'] }}
</x-table-column>

<x-table-column>
    {{ $shopper['check_out'] }}
</x-table-column>

<x-table-column>
    @if ($shopper['status_id'] == 1)
        <a href="{{ route('shopper.checkout', ['shopperUuid' => $shopper['uuid']]) }}" class="bg-yellow-800 border-transparent font-semibold inline-flex px-4 py-2 rounded-md text-white text-xs uppercase">CheckOut</a>
    @endif
</x-table-column>
