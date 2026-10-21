@extends('layouts.master')

@section('body')
@php
    $selectedFamily = isset($dafacsrch) ? trim(ucwords(strtolower(implode(' ', array_filter([$dafacsrch->fname, $dafacsrch->mname, $dafacsrch->surname, $dafacsrch->ext]))))) : null;
    $members = isset($dafacsrch) ? array_values(array_filter(array_map('trim', explode(',', (string) $dafacsrch->mem_fname)))) : [];
    if ($selectedFamily && ! count($members)) $members = [$selectedFamily];
@endphp
<div class="content dafac-page">
    <div class="container-fluid">
        <div class="row dafac-shell">
            <div class="col-12 dafac-workspace">
                <div class="dafac-breadcrumb-row">
                    <nav aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dafacRead') }}">FACED records</a></li>
                            <li class="breadcrumb-item" aria-current="page">Assistance</li>
                        </ol>
                    </nav>
                    <div class="dafac-header-actions">
                        <a href="{{ route('dafacRead') }}" class="dafac-header-link"><i class="fas fa-folder-open" aria-hidden="true"></i> Family records</a>
                        <a href="{{ route('dafacRead') }}" class="dafac-back-icon" aria-label="Back to FACED records" title="Back to records"><i class="fas fa-arrow-left" aria-hidden="true"></i></a>
                    </div>
                </div>

                <div class="dafac-page-head">
                    <div>
                        <p class="dafac-eyebrow">FACED workspace · Family assistance</p>
                        <h1>Assistance records</h1>
                        <p class="dafac-page-head__copy">Choose a family to review assistance and record new support.</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger dafac-error-summary" role="alert">
                        <strong>Check the assistance details before saving.</strong>
                        <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <section class="card dafac-list-card dafac-family-picker" aria-labelledby="select-family-title">
                    <div class="card-body">
                        <form action="{{ route('assRead') }}" method="get" class="dafac-family-search">
                            <div class="dafac-family-search__field">
                                <label for="assistance-family" id="select-family-title">Select a family</label>
                                <select id="assistance-family" class="form-control" name="did" required>
                                    <option value="">Search family name</option>
                                    @foreach ($dafacs as $dafac)
                                        <option value="{{ Crypt::encryptString($dafac->id) }}" @selected(isset($dafacsrch) && $dafacsrch->id === $dafac->id)>{{ trim(ucwords(strtolower(implode(' ', array_filter([$dafac->fname, $dafac->mname, $dafac->surname, $dafac->ext]))))) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary dafac-primary-action"><i class="fas fa-magnifying-glass" aria-hidden="true"></i> View assistance</button>
                        </form>
                    </div>
                </section>

                @if (isset($dafacsrch))
                    <div class="dafac-assistance-summary">
                        <div><span>Selected family</span><strong>{{ $selectedFamily }}</strong></div>
                        <div><span>Assistance records</span><strong>{{ number_format($assistances->count()) }}</strong></div>
                        <div><span>Total value</span><strong>₱{{ number_format((float) $assistances->sum('cost'), 2) }}</strong></div>
                    </div>

                    <section class="card dafac-list-card" aria-labelledby="new-assistance-title">
                        <div class="card-header dafac-list-card__head">
                            <h2 id="new-assistance-title">Record assistance</h2>
                            <p>Enter the assistance given to this family.</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('assCreate') }}" method="post" class="dafac-assistance-form">
                                @csrf
                                <input type="hidden" name="did" value="{{ request('did') }}">
                                <label><span>Family member <b>*</b></span><select name="fam_mem" class="form-control" required>
                                    @foreach ($members as $member)<option value="{{ $member }}" @selected(old('fam_mem') === $member)>{{ $member }}</option>@endforeach
                                </select></label>
                                <label><span>Emergency or disaster <b>*</b></span><input type="text" name="em_dis" class="form-control" value="{{ old('em_dis') }}" required></label>
                                <label><span>Assistance <b>*</b></span><input type="text" name="assistance" class="form-control" value="{{ old('assistance') }}" required></label>
                                <label><span>Unit <b>*</b></span><input type="text" name="unit" class="form-control" value="{{ old('unit') }}" required></label>
                                <label><span>Quantity <b>*</b></span><input type="number" min="0" step="any" name="quantity" class="form-control" value="{{ old('quantity') }}" required></label>
                                <label><span>Cost (₱) <b>*</b></span><input type="number" min="0" step="0.01" name="cost" class="form-control" value="{{ old('cost') }}" required></label>
                                <label><span>Provider <b>*</b></span><input type="text" name="provider" class="form-control" value="{{ old('provider') }}" required></label>
                                <label><span>Date <b>*</b></span><input type="date" name="created_at" class="form-control" value="{{ old('created_at', now()->toDateString()) }}" required></label>
                                <div class="dafac-assistance-form__action"><button type="submit" class="btn btn-primary dafac-primary-action"><i class="fas fa-floppy-disk" aria-hidden="true"></i> Save assistance</button></div>
                            </form>
                        </div>
                    </section>

                    <section class="card dafac-list-card" aria-labelledby="assistance-history-title">
                        <div class="card-header dafac-list-card__head"><h2 id="assistance-history-title">Assistance history</h2><p>All recorded support for {{ $selectedFamily }}.</p></div>
                        <div class="card-body">
                            <div class="table-responsive dafac-table-wrap">
                                <table id="example1" class="table table-hover dafac-table" aria-label="Assistance history">
                                    <thead><tr><th scope="col">Date</th><th scope="col">Family member</th><th scope="col">Assistance</th><th scope="col">Unit</th><th scope="col">Quantity</th><th scope="col">Cost</th><th scope="col">Provider</th><th scope="col">Action</th></tr></thead>
                                    <tbody>
                                        @foreach ($assistances as $ass)
                                            <tr id="tr-{{ $ass->id }}">
                                                <td>{{ $ass->created_at ? \Carbon\Carbon::parse($ass->created_at)->format('M j, Y') : '—' }}</td>
                                                <td>{{ $ass->fam_mem }}</td><td>{{ $ass->assistance }}</td><td>{{ $ass->unit }}</td>
                                                <td>{{ number_format((int) $ass->quantity) }}</td><td>₱{{ number_format((float) $ass->cost, 2) }}</td><td>{{ $ass->provider }}</td>
                                                <td><button type="button" value="{{ $ass->id }}" class="btn btn-sm btn-outline-danger assistance-delete" aria-label="Delete assistance record dated {{ $ass->created_at ? \Carbon\Carbon::parse($ass->created_at)->format('M j, Y') : 'unknown' }}"><i class="fas fa-trash" aria-hidden="true"></i></button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                @else
                    <div class="dafac-assistance-empty"><i class="fas fa-hand-holding-heart" aria-hidden="true"></i><h2>Choose a family to continue</h2><p>Search above to view its assistance history or record new support.</p></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
