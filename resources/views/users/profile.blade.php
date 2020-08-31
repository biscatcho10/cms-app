@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header"> My Profile </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action=" {{route('users.update-profile' , $user->id) }} " method="post" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label>Name :</label>
                    <input type="text" name="name" class=" form-control" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label>Email :</label>
                    <input type="email" name="email" class=" form-control" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label>About :</label>
                    <textarea name="about" rows="3" class="form-control" placeholder="Tell Us About You"> {{ $profile->about }} </textarea>
                </div>
                <div class="form-group">
                    <label>Facebook :</label>
                    <input type="email" name="facebook" class=" form-control" value="{{ $profile->facebook }}">
                </div>
                <div class="form-group">
                    <label>Twitter :</label>
                    <input type="email" name="twitter" class=" form-control" value="{{ $profile->twitter }}">
                </div>
                <div class="form-group">
                    <label>Picture :</label>
                    <img src=" {{ $user->hasPicture() ? asset('storage/'.$user->getPicture()) : $user->getGravatar() }} " style="width: 100px" class="rounded-sm d-block">
                    <input type="file" name="picture" class=" form-control mt-2">
                </div>


                <div class="form-group">
                    <button class="btn btn-primary form-control w-25 float-right"> Update Profile </button>
                </div>
            </form>
        </div>
    </div>
@endsection
