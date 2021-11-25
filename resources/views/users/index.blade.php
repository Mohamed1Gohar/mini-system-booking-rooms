@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Users</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success disabled" href="{{ route('users.create') }}"> Create New User</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>User Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Roles</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->user_name }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->roles_names }}</td>
                <td>
                    <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                        <a class="btn btn-info disabled" href="{{ route('users.show',$user->id) }}">Show</a>
                        <a class="btn btn-primary disabled" href="{{ route('users.edit',$user->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $users->links() !!}

@endsection
