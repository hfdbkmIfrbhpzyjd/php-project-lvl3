@extends('layouts.app')

@section('title')
    Url {{optional($url)->name}}
@endsection

@section('content')
<div class="container-lg">
    <h1 class="mt-5 mb-3">Url: {{optional($url)->name}}</h1>
    <table class="table table-hover">
        <tr>
            <td>id</td><td>{{optional($url)->id}}</td>
        </tr>
        <tr>
            <td>url</td><td>{{optional($url)->name}}</td>
        </tr>
        <tr>
            <td>created_at</td><td>{{optional($url)->created_at}}</td>
        </tr>
        <tr>
            <td>updated_at</td><td>{{optional($url)->updated_at}}</td>
        </tr>
    </table>
    <h2 class="mt-5 mb-3">Checks</h2>
    {{ Form::open(['url' => route('urls.checks.store', optional($url)->id)]) }}
        <div class="form-row">
            <div class="col-12 col-md-3">
                {{Form::hidden('urlName', optional($url)->name)}}
                {{Form::submit('Run check', ['class' => 'btn btn-block btn-lg btn-primary'])}}
            </div>
        </div>
    {{ Form::close() }}
    @if (isset($urlChecks) && count($urlChecks) > 0)
        @push('header_scripts')
            <script src="{{ asset('/js/update-check-status.js')}}"></script>
        @endpush
        <table class="table table-hover" id='checks_table'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status Code</th>
                    <th>h1</th>
                    <th>Keywords</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
            @foreach($urlChecks as $check)
                <tr id="check-id-{{$check->id}}" data-status="{{$check->status}}" data-id="{{$check->id}}">
                    <td>{{$check->id}}</td>
                    @switch($check->status)
                        @case('pending')
                            <td id='pending-{{$check->id}}' colspan="4" class='alert alert-warning'>
                                <div class="spinner-border spinner-border-sm text-warning" role="status"></div> Waiting for checking site...
                            </td>
                            @break
                        @case('failed')
                            <td colspan="4" class='alert alert-danger'>{{$check->error_msg}}</td>
                            @break
                        @default
                            <td>{{$check->status_code}}</td>
                            <td>{{$check->h1}}</td>
                            <td>{{$check->keywords}}</td>
                            <td>{{$check->description}}</td>
                    @endswitch
                    <td>{{$check->created_at}}</td>
                    <td id='updated_at-{{$check->id}}'>{{$check->updated_at}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Wed didn't checked this site</p>
    @endif
</div>
@endsection