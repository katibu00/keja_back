<table class="table table-striped">
    <thead>
        <tr>
            <th>Nwrk</th>
            <th>ID</th>
            <th>Provider</th>
            <th>Amount</th>
            <th>Buying</th>
            <th>Selling</th>
            <th>Validity</th>
            <th>Type</th>
            <th>S/N</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataPlans as $dataPlan)
        <tr>
            <td>{{ $dataPlan->network_name }}</td>
            <td>{{ $dataPlan->plan_id }}</td>
            <td>{{ $dataPlan->planProvider->name }}</td>
            <td>{{ $dataPlan->amount }}</td>
            <td>{{ $dataPlan->buying_price }}</td>
            <td>{{ $dataPlan->selling_price }}</td>
            <td>{{ $dataPlan->validity }}</td>
            <td>{{ $dataPlan->plan_type }}</td>
            <td>{{ $dataPlan->order_number }}</td>
            <td>
                <a href="{{ route('data-plans.edit', $dataPlan->id) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil"></i> <!-- Edit icon, assuming you are using Bootstrap Icons -->
                </a>
                <form action="{{ route('data-plans.destroy', $dataPlan->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this data plan?')">
                        <i class="bi bi-trash"></i> <!-- Delete icon, assuming you are using Bootstrap Icons -->
                    </button>
                </form>
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>