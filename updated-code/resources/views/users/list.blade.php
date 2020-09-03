@extends('layouts.app')

@section('content')
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">User Management</h2>
    </div>
</header>

<!-- Breadcrumb-->
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">User Management</li>
    </ul>
</div>
<section>
    <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Logged Google User List</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-danger" href="{{route('admin.googleLogin')}}"> Login with Google</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Login Time</th>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($users as $key => $user)

                                <tr class="list-users">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->updated_at->diffForHumans() }}</td>   
                                    <td>
                                        @if(!empty($user->roles))
                                            @foreach($user->roles as $role)
                                                <badge class="badge badge-success">{{ $role->display_name }}</badge>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('admin.users.show',$user->id) }}" title="Show"><i class="fas fa-btn fa-eye"></i></a>
                                        <a class="btn btn-primary" href="{{ route('admin.users.edit',$user->id) }}" title="Edit"><i class="fas fa-btn fa-edit"></i></a>

                                        <form action="{{ url('admin/users/'.$user->id) }}" method="POST" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" id="delete-task-{{ $user->id }}" class="btn btn-danger" title="Delete">
                                                <i class="fas fa-btn fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                        {{ $users->links('vendor.pagination.bootstrap-4') }}
                        <a href="{{ route('admin.users.create') }}" class="btn btn-success">New User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection   