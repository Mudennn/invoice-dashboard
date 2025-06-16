@extends('layouts.dashboard')

@section('content')
    <div style="padding: 40px;">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-2xl font-bold">Contacts</h2>
            <a href="{{ route('contacts.create') }}" class="primary-button">Create</a>
        </div>
        <div class="table-responsive" style="min-height: 200px; overflow-y: auto; margin-top: 32px;">
            <table class="table table-hover table-bordered align-middle text-nowrap" id="invoiceTable">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="text-center" style="width: 5%;">No</th>
                        <th scope="col" style="width: 10%;">Company Name</th>
                        <th scope="col" style="width: 10%;">Registration Number</th>
                        <th scope="col" style="width: 40%;">Entity Type</th>
                        <th scope="col" style="width: 5%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $index => $customer)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->registration_number }}</td>
                            @php
                                $entity_type_text = $customer->entity_type_text;
                                if ($entity_type_text == 'Company') {
                                    $badge_color = 'bg-warning';
                                } elseif ($entity_type_text == 'Individual') {
                                    $badge_color = 'bg-info';
                                } elseif ($entity_type_text == 'General Public') {
                                    $badge_color = 'bg-success';
                                } elseif ($entity_type_text == 'Foreign Company') {
                                    $badge_color = 'bg-danger';
                                } elseif ($entity_type_text == 'Foreign Individual') {
                                    $badge_color = 'bg-secondary';
                                } else {
                                    $badge_color = 'bg-secondary';
                                }
                            @endphp
                            <td><span class="badge {{ $badge_color }}">{{ $entity_type_text }}</span></td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="hide-arrow p-0 border-0" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-symbols-outlined"style="font-size: 18px; color: #646e78;">
                                            more_vert
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a href="{{ route('contacts.edit', $customer->id) }}" class="dropdown-item"
                                                href="#"
                                                style="display: flex; justify-content: start; align-items: center; gap:8px; font-size:14px;"><span
                                                    class="material-symbols-outlined" style="font-size: 14px">
                                                    edit
                                                </span> Edit</a></li>
                                        <li><a href="{{ route('contacts.destroy', $customer->id) }}"
                                                class="dropdown-item text-danger" href="#"
                                                style="display: flex; justify-content: start; align-items: center; gap:8px; font-size:14px;"><span
                                                    class="material-symbols-outlined" style="font-size: 14px">
                                                    delete
                                                </span>Delete</a></li>
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
