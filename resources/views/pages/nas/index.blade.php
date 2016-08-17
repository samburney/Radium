@extends("master")

@section('pageTitle', 'Nas List')
@section('pageDescription', '')
@push('breadcrumbs')
    <li><a href="{{ route('nas::index') }}"><i class="fa fa-group"></i> Nas</a></li>
@endpush

@section("content")
    @include(
        'partials.table.crud-list',
        [
            'title'             => 'Nas List',
            'filterPlaceHolder' => 'Nas',
            'headers'           => ['ID', 'Nas Name', 'Short Name', 'Type', 'Ports', 'Server', 'Community', 'Description'],
            'dataSet'           => $nasList,
            'dataPartial'       => 'pages.user.partials.index-table-data',
        ]
    )
@endsection