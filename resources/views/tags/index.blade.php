@extends('layouts.app')

@section('content')
@if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
<div class="clearfix">
    <a href=" {{ route('tags.create') }} " class="btn btn-primary float-right" style="margin-bottom: 10px">Add Tag</a>
</div>
<div class="card card-default">
        <div class="card-header">All Tags</div>
        <div class="card-body">
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            @if ($tags->count() > 0)
                <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tag Name</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                    @foreach ($tags as $tag)
                        <tbody>
                            <tr>
                                <td> {{$tag->id}} </td>
                                <td> {{$tag->name}} <span class="badge badge-primary">  {{$tag->posts->count()}} </span></td>
                                <td>
                                    @if ($tag->trashed())
                                        <a href="{{ route('restore.tags', $tag->id)}} " class="btn btn-primary btn-sm float-right">Restroe</a>
                                    @else
                                        <a href="{{ route('tags.edit', $tag->id)}} " class="btn btn-primary btn-sm float-right">Edit</a>
                                    @endif
                                </td>
                                <td>
                                    <form action=" {{ route('tags.destroy', $tag->id)}} " method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm float-right">{{ $tag->trashed() ? "Delete" : "Trash" }} </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            @else
               <div class="card-body">
                    <h4>No Tags Yet. </h4>
                </div>
            @endif
        </div>
    </div>
@endsection
