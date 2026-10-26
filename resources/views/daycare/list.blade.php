@extends('layouts.master')

@section('body')
<div class="content module-workspace">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 module-workspace__main">
                @include('partials.workspace-header', ['module' => 'Day care workers', 'title' => 'Child development worker records', 'description' => 'Profiles of day care (child development) workers, printable as ECCD Form 6.', 'count' => $workers->count(), 'actionRoute' => 'daycareForm', 'actionLabel' => 'Add worker profile', 'relatedRoute' => 'daycareBlankPdf', 'relatedIcon' => 'fa-file-pdf', 'relatedLabel' => 'Blank Form 6'])
                <div class="card module-workspace__list-card">
                    <div class="card-header">
                        <h2 class="card-title mb-0">All records</h2>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-hover" aria-label="Child development worker records">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Age</th>
                                        <th scope="col">Sex</th>
                                        <th scope="col">Barangay</th>
                                        <th scope="col">Child development center</th>
                                        <th scope="col">Years as CDW</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @foreach ($workers as $worker)
                                        @php $encryptedId = Crypt::encryptString($worker->id); @endphp
                                        <tr id="tr-{{ $worker->id }}">
                                            <td><strong>{{ $worker->form_name }}</strong></td>
                                            <td>{{ $worker->age }}</td>
                                            <td>{{ $worker->sex }}</td>
                                            <td>{{ $worker->address_barangay }}</td>
                                            <td>{{ $worker->center_name }}</td>
                                            <td>{{ $worker->years_as_cdw ?? '—' }}</td>
                                            <td>{{ $worker->accreditation_status ?: '—' }}</td>
                                            <td>
                                                <div class="d-flex flex-wrap" style="gap: .25rem">
                                                    <a href="{{ route('daycareEdit', ['id' => $encryptedId]) }}" class="btn btn-sm btn-outline-secondary" aria-label="Edit {{ $worker->full_name }}">
                                                        <i class="fas fa-pen" aria-hidden="true"></i> Edit
                                                    </a>
                                                    <a href="{{ route('daycarePdf', ['id' => $encryptedId]) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary" aria-label="Open Form 6 for {{ $worker->full_name }}">
                                                        <i class="fas fa-file-pdf" aria-hidden="true"></i> Form 6
                                                    </a>
                                                    <button type="button" value="{{ $worker->id }}" class="btn btn-sm btn-outline-danger daycare-delete" aria-label="Delete record for {{ $worker->full_name }}">
                                                        <i class="fas fa-trash" aria-hidden="true"></i> Delete
                                                    </button>
                                                </div>
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
    $(document).on('click', '.daycare-delete', function () {
        var id = $(this).val();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (!result.isConfirmed) return;
            $.ajax({
                type: 'DELETE',
                url: "{{ route('daycareDelete', ':id') }}".replace(':id', id),
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function () {
                    Swal.fire({ title: 'Deleted!', text: 'Successfully Deleted!', icon: 'success', showConfirmButton: false, timer: 1000 })
                        .then(function () { window.location.reload(); });
                },
                error: function () {
                    toastr.error('The record could not be deleted. Please try again.');
                }
            });
        });
    });
</script>
@endpush
@endsection
