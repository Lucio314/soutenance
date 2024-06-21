@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h1 class="my-4">Details tickets</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Companies</th>
                <th>Application</th>
                <th>Total</th>
                <th>Resolus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
                @php
                    $applicationCount = $company->applications->count();
                @endphp

                @if($applicationCount > 0)
                    @foreach ($company->applications as $index => $app)
                        <tr style="text-align: center">
                            @if($index === 0)
                                <td rowspan="{{ $applicationCount }}">{{ $company->cpn_name }}</td>
                            @endif
                            <td>{{ $app->app_name }}</td>
                            <td>{{ $app->tickets->count() }}</td>
                            <td>{{ $app->tickets->where('status', 'Terminé')->count() }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ $company->cpn_name }}</td>
                        <td colspan="3">Aucune application</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection
