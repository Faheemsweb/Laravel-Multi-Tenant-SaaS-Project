@extends('landlord.layouts.app')

@section('title', 'Landlord - Tenant Management')
@section('header', 'Tenant Management')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title">All Tenants</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Domain</th>
                        <th scope="col">Database</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tenants as $tenant)
                        <tr>
                            <th scope="row">{{ $tenant->id }}</th>
                            <td>{{ $tenant->name }}</td>
                            <td><a href="http://{{ $tenant->domain }}" target="_blank">{{ $tenant->domain }}</a></td>
                            <td>{{ $tenant->database }}</td>
                            <td>
                                <span class="badge
                                    @if($tenant->provisioning_status == 'completed') bg-success
                                    @elseif($tenant->provisioning_status == 'pending') bg-warning
                                    @else bg-danger
                                    @endif">
                                    {{ ucfirst($tenant->provisioning_status) }}
                                </span>
                            </td>
                            <td>{{ $tenant->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <form action="{{ route('landlord.tenants.status', $tenant) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @if ($tenant->provisioning_status === 'active')
                                        <input type="hidden" name="status" value="suspended">
                                        <button type="submit">Suspend</button>
                                    @else
                                        <input type="hidden" name="status" value="active">
                                        <button type="submit">Activate</button>
                                    @endif
                                </form>
                                <form action="{{ route('landlord.tenants.destroy', $tenant) }}" method="POST" style="display:inline;" onsubmit="return confirm('WARNING: This will permanently delete the tenant and all their data. Are you absolutely sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: red;">Delete</button>
                                </form>

                                </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No tenants found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
