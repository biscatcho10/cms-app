@extends('layouts.app')


@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
<div class="card card-default">
        <div class="card-header">All Users</div>
        <div class="card-body">
            @if ($users->count() > 0)
                <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>User Name</th>
                                <th>Role</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                    @foreach ($users as $user)
                        <tbody>
                            <tr>
                                <td> {{$user->id}} </td>
                                <td>
                                    {{-- <img src=" {{ asset('storage/'.$user->image) }} " style="width: 100px ; height: 80px;"> --}}
                                    {{-- <img src="{{ Gravatar::src('itsolutionstuff@gmail.com', 200) }}"> --}}
                                    <img src="{{ $user->hasPicture() ? asset('storage/'.$user->getPicture()) : $user->getGravatar() }}" style=" width: 60px" class="rounded-circle">
                                </td>
                                <td> {{$user->name}} </td>
                                @if (!$user->isAdmin())
                                    <td>
                                        <form action=" {{ route('users.make-admin' , $user->id) }} " method="post">
                                            @csrf
                                            <button class="btn btn-success btn-sm" type="submit">Make Admin</button>
                                        </form>
                                    </td>
                                @else
                                   <td> {{ $user->role }} </td>
                                @endif
                                @if (!$user->trashed())
                                    <td> <a href="{{ route('users.edit', $user->id)}} " class="btn btn-primary btn-sm float-right">Edit</a> </td>
                                @else
                                    <td> <a href="{{ route('restore.users', $user->id)}} " class="btn btn-primary btn-sm float-right">Restore</a> </td>
                                @endif
                                <td>
                                    <form action=" {{ route('users.destroy', $user->id)}} " method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm float-right"> {{ $user->trashed() ? "Remove" : "Trash" }} </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            @else
               <div class="card-body">
                    <h4>No Users Yet.</h4>
               </div>
            @endif

            {{-- <div class="w-25 mx-auto"> {{ $posts->links() }} </div> --}}

        </div>
    </div>
@endsection

