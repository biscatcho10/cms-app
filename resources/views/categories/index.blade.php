@extends('layouts.app')

@section('content')
@if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
<div class="clearfix">
    <a href=" {{ route('categories.create') }} " class="btn btn-primary float-right" style="margin-bottom: 10px">Add Category</a>
</div>
<div class="card card-default">
        <div class="card-header">All Categories</div>
        <div class="card-body">
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            @if ($categories->count() > 0)
                <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                    @foreach ($categories as $category)
                        <tbody>
                            <tr>
                                <td> {{$category->id}} </td>
                                <td> {{$category->name}} </td>
                                <td>
                                    @if ($category->trashed())
                                        <a href="{{ route('restore.categories', $category->id)}} " class="btn btn-primary btn-sm float-right">Restroe</a>
                                    @else
                                        <a href="{{ route('categories.edit', $category->id)}} " class="btn btn-primary btn-sm float-right">Edit</a>
                                    @endif
                                </td>
                                <td>
                                    <form action=" {{ route('categories.destroy', $category->id)}} " method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm float-right">{{ $category->trashed() ? "Delete" : "Trash" }} </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            @else
               <div class="card-body">
                    <h4>No Categories Yet. </h4>
                </div>
            @endif
        </div>
    </div>
@endsection
