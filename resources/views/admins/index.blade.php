@extends('layouts.dashboard', ['title' => 'Admins'])

@section('content')
    <div style="padding: 40px;">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-2xl font-bold">Admins</h2>
            @if(Auth::user()->role === 'super_admin')
            <a href="{{ route('admins.create') }}" class="primary-button">Create</a>
            @endif
        </div>
        <div class="table-responsive" style="min-height: 200px; overflow-y: auto; margin-top: 32px;">
            <table class="table table-hover table-bordered align-middle text-nowrap" id="invoiceTable">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="text-center" style="width: 1%;">No</th>
                        <th scope="col" style="width: 3%;" class="text-center">Name</th>
                        <th scope="col" style="width: 10%;">Email</th>
                        <th scope="col" style="width: 10%;">Role</th>
                        <th scope="col" style="width: 10%;">Created At</th>
                        <th scope="col" style="width: 5%;" class="text-center">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $index => $admin)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <span class="badge {{ $admin->role === 'super_admin' ? 'bg-danger' : 'bg-primary' }}">
                                    {{ ucfirst(str_replace('_', ' ', $admin->role)) }}
                                </span>
                            </td>
                            <td>{{ $admin->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn hide-arrow p-0 border-0" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-symbols-outlined"style="font-size: 18px; color: #646e78;">
                                            more_vert
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu w-50" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            @if(Auth::user()->role === 'super_admin' || $admin->role !== 'super_admin')
                                            <a href="{{ route('admins.edit', $admin->id) }}" class="dropdown-item"
                                                href="#"
                                                style="display: flex; justify-content: start; align-items: center; gap:8px; font-size:14px;"><span
                                                    class="material-symbols-outlined" style="font-size: 14px">
                                                    edit
                                                </span> Edit</a></li>
                                            @endif
                                        <li>
                                            @if (Auth::user()->id !== $admin->id && (Auth::user()->role === 'super_admin' || $admin->role !== 'super_admin'))
                                            <a href="{{ route('admins.destroy', $admin->id) }}"
                                                class="dropdown-item text-danger" href="#"
                                                style="display: flex; justify-content: start; align-items: center; gap:8px; font-size:14px;"><span
                                                    class="material-symbols-outlined" style="font-size: 14px">
                                                    delete
                                                </span>Delete</a></li>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
