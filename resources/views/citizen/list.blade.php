@extends('layouts.master')

@section('body')
<div class="content module-workspace">
    <div class="container-fluid" >
        <div class="row">
            <div class="col-12 module-workspace__main">
                @include('partials.workspace-header', ['module' => 'Senior citizens', 'title' => 'Senior citizen records', 'description' => 'Search, review, and register senior citizens.', 'count' => $citizen->count(), 'modalTarget' => '#modal-citizen', 'actionLabel' => 'Add senior citizen'])
                <div class="card module-workspace__list-card">
                    <div class="card-header d-flex flex-wrap align-items-center" style="gap: .5rem">
                        <h2 class="card-title mb-0 mr-auto">All records</h2>
                        <span class="text-muted small" id="idSelectionNote" aria-live="polite">Tick seniors to generate their ID cards.</span>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="idClearSelection" disabled>Clear selection</button>
                        <button type="button" class="btn btn-sm btn-success" id="idGenerateSelected" disabled>
                            <i class="fas fa-id-card" aria-hidden="true"></i> Generate ID cards (<span id="idSelectedCount">0</span>)
                        </button>
                    </div>

                    @include('citizen/modal-citizen')
                    @include('citizen/modal-idcards')

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-hover" data-order='[[1, "asc"]]'>
                                <thead>
                                    <tr>
                                        <th data-orderable="false" class="text-center" style="width: 2rem">
                                            <input type="checkbox" id="idSelectAll" aria-label="Select all senior citizens shown by the search">
                                        </th>
                                        <th>No</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Ext. Name</th>
                                        <th>Gender</th>
                                        <th>Birthday</th>
                                        <th>Age</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @php $no = 1; @endphp
                                    @foreach($citizen as $data)
                                    <tr id="tr-{{ $data->id }}" class="">
                                        <td class="text-center">
                                            <input type="checkbox" class="id-select" value="{{ $data->id }}" aria-label="Select {{ $data->fname }} {{ $data->lname }} for ID card">
                                        </td>
                                        <td>{{ $no++ }}</td>
                                        <td class="text-capitalize">{{ $data->lname }}</td>
                                        <td class="text-capitalize">{{ $data->fname }}</td>
                                        <td class="text-capitalize">{{ $data->mname }}</td>
                                        <td class="text-capitalize">{{ $data->ext }}</td>
                                        <td class="text-capitalize">{{ $data->gender }}</td>
                                        <td class="text-capitalize">{{ $data->birth_date_label }}</td>
                                        <td class="text-capitalize">{{ $data->current_age ?? '—' }}</td>
                                        <td class="text-capitalize">
                                            <div class="dropdown">
                                                <span class="badge {{ ($data->status == 'Waiting') ? 'badge-warning' : '' }} {{ ($data->status == 'Active / Pensioner') ? 'badge-success' : '' }} {{ ($data->status == 'Deceased') ? 'badge-danger' : '' }} dropdown-toggle" id="statusDropdown-{{ $data->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{ $data->status }}
                                                </span>
                                                <div class="dropdown-menu" aria-labelledby="statusDropdown-{{ $data->id }}">
                                                    <a class="dropdown-item" href="#" onclick="updateStatus('{{ $data->id }}', 'Waiting')">Waiting</a>
                                                    <a class="dropdown-item" href="#" onclick="updateStatus('{{ $data->id }}', 'Active / Pensioner')">Active / Pensioner</a>
                                                    <a class="dropdown-item" href="#" onclick="updateStatus('{{ $data->id }}', 'Deceased')">Deceased</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('citizenReadPdf', ['id' => encrypt($data->id)]) }}" title="View Form" target="_blank" class="btn btn-warning btn-xs btn-edit">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>

                                            <button type="button" data-id="{{ $data->id }}" data-name="{{ $data->fname }} {{ $data->lname }}" title="Senior ID card" aria-label="Generate ID card for {{ $data->fname }} {{ $data->lname }}" class="btn btn-success btn-xs js-id-single"><i class="fas fa-id-card"></i></button>

                                            <a href="{{ route('citizenMoreInfo', ['encryptedId' => encrypt($data->id)]) }}" title="More Info" class="btn btn-info btn-xs btn-edit">
                                                <i class="fas fa-exclamation-circle"></i>
                                            </a>
                                            <button value="{{ $data->id }}" title="Delete" class="btn btn-danger btn-xs citizen-delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(function () {
        const table = $('#example1').DataTable();
        const cardsPerSheet = 10;
        const selectedIds = () => table.$('.id-select:checked').map(function () { return this.value; }).get();

        function refreshSelection() {
            const count = selectedIds().length;
            $('#idSelectedCount').text(count);
            $('#idGenerateSelected, #idClearSelection').prop('disabled', count === 0);
            $('#idSelectionNote').text(count ? count + ' selected across all pages' : 'Tick seniors to generate their ID cards.');

            const shown = table.$('.id-select', { search: 'applied' });
            const shownChecked = shown.filter(':checked').length;
            $('#idSelectAll')
                .prop('checked', shown.length > 0 && shownChecked === shown.length)
                .prop('indeterminate', shownChecked > 0 && shownChecked < shown.length);
        }

        function openIdDialog(ids, label) {
            const sheets = Math.ceil(ids.length / cardsPerSheet);
            const $ids = $('#idCardIds').empty();
            ids.forEach(function (id) { $ids.append($('<input type="hidden" name="ids[]">').val(id)); });
            $('#idCardSummary').text(label + ' — ' + ids.length + (ids.length === 1 ? ' card' : ' cards') + ' on ' + sheets + (sheets === 1 ? ' sheet' : ' sheets') + ' of 8.5" × 13" paper.');
            $('#modal-idcards').modal('show');
        }

        $('#example1').on('change', '.id-select', refreshSelection);
        table.on('draw', refreshSelection);

        $('#idSelectAll').on('change', function () {
            table.$('.id-select', { search: 'applied' }).prop('checked', this.checked);
            refreshSelection();
        });

        $('#idClearSelection').on('click', function () {
            table.$('.id-select').prop('checked', false);
            refreshSelection();
        });

        $('#idGenerateSelected').on('click', function () {
            const ids = selectedIds();
            if (ids.length) openIdDialog(ids, 'Selected senior citizens');
        });

        $(document).on('click', '.js-id-single', function () {
            openIdDialog([String($(this).data('id'))], $(this).data('name'));
        });

        // The PDF opens in a new tab; close the dialog behind it.
        $('#idCardForm').on('submit', function () {
            setTimeout(function () { $('#modal-idcards').modal('hide'); }, 100);
        });

        refreshSelection();
    });
</script>
@endpush
@endsection
