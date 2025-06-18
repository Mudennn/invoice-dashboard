@extends('layouts.dashboard', ['title' => 'Classifications'])

@section('content')
    <div style="padding: 40px;">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-2xl font-bold">Classifications</h2>
            <a href="{{ route('classifications.create') }}" class="primary-button">Create</a>
        </div>
        <div class="table-responsive" style="min-height: 200px; overflow-y: auto; margin-top: 32px;">
            <table class="table table-hover table-bordered align-middle text-nowrap" id="invoiceTable">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="text-center" style="width: 1%;">No</th>
                        <th scope="col" style="width: 3%;" class="text-center">Classification Code</th>
                        <th scope="col" style="width: 10%;">Description</th>
                        <th scope="col" style="width: 5%;" class="text-center">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($classifications as $index => $classification)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $classification->classification_code }}</td>
                            <td>{{ $classification->description }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn hide-arrow p-0 border-0" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-symbols-outlined"style="font-size: 18px; color: #646e78;">
                                            more_vert
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu w-50" aria-labelledby="dropdownMenuButton1">
                                        <li><a href="{{ route('classifications.edit', $classification->id) }}" class="dropdown-item"
                                                href="#"
                                                style="display: flex; justify-content: start; align-items: center; gap:8px; font-size:14px;"><span
                                                    class="material-symbols-outlined" style="font-size: 14px">
                                                    edit
                                                </span> Edit</a></li>
                                        <li><a href="{{ route('classifications.destroy', $classification->id) }}"
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
