@extends('layouts.app')


@section('stylesheet')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="card card-default">
        <div class="card-header"> {{ isset($post) ? "Update The Post" : "Add A New Post" }} </div>
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
            <form action=" {{ isset($post) ? route('posts.update' , $post->id) : route('posts.store') }} " method="post" enctype="multipart/form-data">
                @csrf
                @isset($post)
                    @method('PUT')
                @endisset
                <div class="form-group">
                    <label> Tile :</label>
                    <input type="text" name="title" class="form-control"
                    placeholder="Add The Post Title" value="{{ isset($post) ? $post->title : "" }}">
                </div>
                <div class="form-group">
                    <label> Description :</label>
                    <input type="text" name="description" class="form-control"
                    placeholder="Add The Description" value="{{ isset($post) ? $post->description : "" }}">
                </div>
                <div class="form-group">
                    <label> Content :</label>
                    <textarea name="content" class="form-control"
                    placeholder="Add The Content"  rows="4">{{ isset($post) ? $post->content : "" }}</textarea>
                </div>
                @if (isset($post))
                    <div class="form-group">
                        <img src=" {{asset('storage/'.$post->image)}} " style="width: 250px">
                    </div>
                @endif
                <div class="form-group">
                    <label> Image :</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label for="SC">Select A Category</label>
                    <select name="categoryID" class="custom-select form-control" id="SC">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                      </select>
                </div><!-- Category -->
                @if ($tags->count() > 0 && isset($post) )
                    <div class="form-group">
                        <label for="SC">Select A Tag</label>
                        <select name="tags[]" class="custom-select form-control tags" id="SC" multiple>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}"
                                    @if ($post->hasTag($tag->id))
                                        selected
                                    @endif
                                    >
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div><!-- Tag -->
                @endif
                <div class="form-group">
                    <button type="submit" class="btn btn-primary form-control w-25 float-right">
                        {{ isset($post) ? "Update Post" : "Add Post" }}
                    </button>
                </div>
                <input type="hidden" name="user_id" value=" {{Auth::user()->id}} ">
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.tags').select2();
        });
    </script>
@endsection
