@extends('layouts.app')


@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
<div class="clearfix">
    <a href=" {{ route('posts.create') }} " class="btn btn-primary float-right" style="margin-bottom: 10px">Add Post</a>
</div>
<div class="card card-default">
        <div class="card-header">All Posts</div>
        <div class="card-body">
            @if ($posts->count() > 0)
                <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Post Tile</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                    @foreach ($posts as $post)
                        <tbody>
                            <tr>
                                <td> {{$post->id}} </td>
                                <td> <img src=" {{ asset('storage/'.$post->image) }} " style="width: 100px ; height: 80px;"> </td>
                                <td> {{$post->title}} </td>
                                @if (!$post->trashed())
                                    <td> <a href="{{ route('posts.edit', $post->id)}} " class="btn btn-primary btn-sm float-right">Edit</a> </td>
                                @else
                                    <td> <a href="{{ route('restore.posts', $post->id)}} " class="btn btn-primary btn-sm float-right">Restore</a> </td>
                                @endif
                                <td>
                                    <form action=" {{ route('posts.destroy', $post->id)}} " method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm float-right"> {{ $post->trashed() ? "Remove" : "Trash" }} </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            @else
               <div class="card-body">
                    <h4>No Posts Yet.</h4>
               </div>
            @endif

            {{-- <div class="w-25 mx-auto"> {{ $posts->links() }} </div> --}}

        </div>
    </div>
@endsection

