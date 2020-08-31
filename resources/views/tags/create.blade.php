@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header"> {{ isset($tag) ? "Update The Tag" : "Add A New Tag" }} </div>
        <div class="card-body">
            {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
            <form action=" {{ isset($tag) ? route('tags.update' , $tag->id) : route('tags.store') }} " method="post">
                @csrf
                @isset($tag)
                    @method('PUT')
                @endisset
                <div class="form-group">
                    <label>Tag Name :</label>
                    <input type="text" name="name" class=" form-control @error('name') is-invalid  @enderror"
                    placeholder="Add A New Tag" value="{{ isset($tag) ? $tag->name : "" }}">
                    @error('name')
                        <div class="alert alert-danger"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-primary form-control w-25 float-right">
                        {{ isset($tag) ? "Update Tag" : "Add Tag" }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
