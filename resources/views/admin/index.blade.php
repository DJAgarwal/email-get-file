@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0">Logged In Users</h5>
                        <a href="{{ route('files.create') }}" class="btn btn-primary">Create File</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <div class="table-responsive" style="margin-top:10px;">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Last Seen</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $dt)
                                <tr>
                                    <td>{{$dt->name}}</td>
                                    <td>{{$dt->email}}</td>
                                    <td>{{ Carbon\Carbon::parse($dt->last_seen)->diffForHumans() }}</td>
                                    <td>
                                    @if(Cache::has('user-is-online-' . $dt->id))
                                    <span>Online</span>
                                    @else
                                    <span>Offline</span>
                                    @endif
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
@endsection