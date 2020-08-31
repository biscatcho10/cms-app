<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Category;
use App\Tag;
use App\User;

class PostsController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');

        $this->middleware('checkCategory')->only('create');

        // $this->middleware('subscribed')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories' , Category::all())->with('tags' , Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        // dd($request->image->store('images' , 'public'));

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $request->image->store('images' , 'public'),
            'category_id' => $request->categoryID,
            'user_id' => $request->user_id
        ]);

        if($request->tags){
            $post->tags()->attach($request->tags);
        }

        session()->flash('success' , 'The Post Created Successfully ');
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $user = $post->user;
        $profile = $user->profile;
        return view('posts.show' , [
            'post' => $post ,
            'categories' => Category::all(),
            'profile' => $profile,
            'user' => $user,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post' ,$post )->with('categories' , Category::all())->with('tags' , Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
        ]);

        $data = $request->only(['title', 'description' , 'content']);
        if($request->hasFile('image')){
            $image = $request->image->store('images' , 'public');
            Storage::disk('public')->delete($post->image);
            $data['image'] = $image;
        }

        if($request->tags){
            $post->tags()->sync($request->tags);
        }

        $post->update($data);
        session()->flash('success' , 'The Post Updated Successfully ');
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $post->delete();
        // session()->flash('success' , 'The Post Trashed Successfully ');
        // return redirect()->route('posts.index');

        $post = Post::withTrashed()->where('id' , $id)->first();
        if($post->trashed()){
            Storage::disk('public')->delete($post->image);
            $post->forceDelete();
            session()->flash('success' , 'The Post Removed Successfully ');
        }else{
            $post->delete();
            session()->flash('success' , 'The Post Trashed Successfully ');
        }
        return redirect()->route('posts.index');

    }

    public function trashed(){
        $trashed = Post::onlyTrashed()->get();
        return view('posts.index')->with('posts' , $trashed);
    }

    public function restore($id){
        $post = Post::withTrashed()->where('id' , $id)->restore();
        session()->flash('success' , 'The Post Restored Successfully ');
        return redirect()->route('posts.index');
    }
}
