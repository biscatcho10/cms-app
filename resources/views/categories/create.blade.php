@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header"> {{ isset($category) ? "Update The Category" : "Add A New Category" }} </div>
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
            <form action=" {{ isset($category) ? route('categories.update' , $category->id) : route('categories.store') }} " method="post">
                @csrf
                @isset($category)
                    @method('PUT')
                @endisset
                <div class="form-group">
                    <label>Category Name :</label>
                    <input type="text" name="name" class=" form-control @error('name') is-invalid  @enderror"
                    placeholder="Add A New Category" value="{{ isset($category) ? $category->name : "" }}">
                    @error('name')
                        <div class="alert alert-danger"> {{ $message }} </div>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn btn-primary form-control w-25 float-right">
                        {{ isset($category) ? "Update Category" : "Add Category" }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
