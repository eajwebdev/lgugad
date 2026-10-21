@extends('layouts.master')

@section('body')
<div class="content dafac-page">
    <div class="container-fluid">
        <div class="row dafac-shell">
            <div class="col-12 dafac-workspace">
                <div class="dafac-breadcrumb-row">
                    <nav aria-label="Breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">FACED records</li>
                        </ol>
                    </nav>
                    <div class="dafac-header-actions">
                        <a href="{{ route('assRead') }}" class="dafac-header-link"><i class="fas fa-hand-holding-heart" aria-hidden="true"></i> Assistance</a>
                        <a href="{{ route('dashboard') }}" class="dafac-back-icon" aria-label="Back to dashboard" title="Back to dashboard"><i class="fas fa-arrow-left" aria-hidden="true"></i></a>
                    </div>
                </div>

                <div class="dafac-page-head dafac-page-head--compact">
                    <div>
                        <p class="dafac-eyebrow">FACED workspace · Family assistance data</p>
                        <h1>Family records</h1>
                        <p class="dafac-page-head__copy">Find a family, review assistance, or add a new record. <span class="dafac-count-inline">{{ number_format($dafacs->count()) }} {{ $dafacs->count() === 1 ? 'record' : 'records' }}</span></p>
                    </div>
                    <a href="{{ route('dafacForm') }}" class="btn btn-primary dafac-primary-action">
                        <i class="fas fa-plus" aria-hidden="true"></i> Add family record
                    </a>
                </div>

                <section class="card dafac-list-card" aria-labelledby="dafac-list-title">
                    <div class="card-header dafac-list-card__head">
                        <div>
                            <h2 id="dafac-list-title">All records</h2>
                            <p>Search by name, serial number, or location. Use the actions to manage each family.</p>
                        </div>
                    </div>

                    @include('dafac.modal')

                    <div class="card-body">
                        <div class="table-responsive dafac-table-wrap">
                            <table id="example1" class="table table-hover dafac-table" aria-label="FACED family records">
                                <thead>
                                    <tr>
                                        <th scope="col">Serial #</th>
                                        <th scope="col">Family head</th>
                                        <th scope="col">Occupation</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Evacuation site</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @foreach ($dafacs as $dafac)
                                        <tr id="tr-{{ $dafac->id }}">
                                            <td><span class="dafac-serial">{{ $dafac->serial ?: '—' }}</span></td>
                                            <td><strong class="dafac-family-name">{{ trim(ucfirst($dafac->fname) . ' ' . ucfirst($dafac->mname) . ' ' . ucfirst($dafac->surname) . ' ' . ucfirst($dafac->ext)) }}</strong></td>
                                            <td>{{ $dafac->occupation ? ucfirst($dafac->occupation) : '—' }}</td>
                                            <td>{{ $dafac->gender === 'M' ? 'Male' : ($dafac->gender === 'F' ? 'Female' : '—') }}</td>
                                            <td>
                                                @php $address = array_filter([$dafac->brgyname, $dafac->cityname, $dafac->provincename]); @endphp
                                                {{ $address ? implode(', ', array_map(fn ($part) => ucwords(strtolower($part)), $address)) : '—' }}
                                            </td>
                                            <td>{{ $dafac->brgy_evac_site ?: '—' }}</td>
                                            <td>
                                                <div class="dafac-row-actions">
                                                    <a href="{{ route('assRead', ['did' => Crypt::encryptString($dafac->id)]) }}" class="btn btn-sm btn-outline-primary" aria-label="View assistance for {{ $dafac->fname }} {{ $dafac->surname }}">
                                                        <i class="fas fa-hand-holding-heart" aria-hidden="true"></i> Assistance
                                                    </a>
                                                    <a href="{{ route('dafacEdit', ['id' => Crypt::encryptString($dafac->id)]) }}" class="btn btn-sm btn-outline-secondary" aria-label="Edit {{ $dafac->fname }} {{ $dafac->surname }}">
                                                        <i class="fas fa-pen" aria-hidden="true"></i> Edit
                                                    </a>
                                                    <a href="{{ route('dafacPdf', ['id' => Crypt::encryptString($dafac->id), 'f' => '1']) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary" aria-label="Open front PDF for {{ $dafac->fname }} {{ $dafac->surname }}"><i class="fas fa-file-pdf" aria-hidden="true"></i> Front PDF</a>
                                                    <a href="{{ route('dafacPdf', ['id' => Crypt::encryptString($dafac->id), 'f' => '2']) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary" aria-label="Open back PDF for {{ $dafac->fname }} {{ $dafac->surname }}"><i class="fas fa-file-pdf" aria-hidden="true"></i> Back PDF</a>
                                                    <button type="button" value="{{ $dafac->id }}" class="btn btn-sm btn-outline-danger dafac-delete" aria-label="Delete record for {{ $dafac->fname }} {{ $dafac->surname }}">
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
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
