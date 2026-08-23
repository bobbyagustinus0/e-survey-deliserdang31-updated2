@extends('layouts.app')
@section('title', 'API Contract - Integrasi')

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-file-earmark-text"></i> API Contract — Integrasi E-Survey</span>
        <a href="{{ route('integrasi.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Integrasi
        </a>
    </div>
    <div class="card-body api-contract-doc">
        {!! $html !!}
    </div>
</div>

<style>
    .api-contract-doc h1 {
        font-size: 1.6rem;
        margin-top: 0;
        margin-bottom: 1rem;
    }

    .api-contract-doc h2 {
        font-size: 1.3rem;
        margin-top: 2rem;
        padding-top: .5rem;
        border-top: 1px solid #e9ecef;
    }

    .api-contract-doc h3 {
        font-size: 1.1rem;
        margin-top: 1.5rem;
    }

    .api-contract-doc p {
        line-height: 1.6;
    }

    .api-contract-doc code {
        background: #f1f3f5;
        color: #d6336c;
        padding: .15em .4em;
        border-radius: .3rem;
        font-size: .9em;
    }

    .api-contract-doc pre {
        background: #212529;
        color: #e9ecef;
        padding: 1rem;
        border-radius: .5rem;
        overflow-x: auto;
    }

    .api-contract-doc pre code {
        background: transparent;
        color: inherit;
        padding: 0;
        font-size: .875rem;
    }

    .api-contract-doc table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }

    .api-contract-doc table th,
    .api-contract-doc table td {
        border: 1px solid #dee2e6;
        padding: .5rem .75rem;
        text-align: left;
        vertical-align: top;
    }

    .api-contract-doc table th {
        background: #f8f9fa;
    }

    .api-contract-doc blockquote {
        border-left: 4px solid #0d6efd;
        padding: .5rem 1rem;
        background: #f8f9fa;
        color: #495057;
        margin: 1rem 0;
    }

    .api-contract-doc hr {
        margin: 2rem 0;
    }
</style>

@endsection