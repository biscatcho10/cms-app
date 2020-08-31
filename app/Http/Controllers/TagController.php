<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Http\Requests\TagRequest;

use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tags.index')->with('tags' , Tag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        // $request->validate([
        //     'name' => 'required|unique:categories'
        // ]);

        // Category::create([
        //     "name" => $request->name
        // ]);

        Tag::create($request->all());
        session()->flash('success', 'Tag Created Successfully');
        return redirect(route('tags.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('tags.create')->with('tag' , $tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update([
            'name' => $request->name,
        ]);
        session()->flash('success', 'Tag Updated Successfully');
        return redirect()->route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $category->delete();
        // session()->flash('success', 'Categroy Deleted Successfully');
        // return redirect()->route('categories.index');

        $tag = Tag::withTrashed()->where('id', $id)->first();
        if($tag->trashed()){
            $tag->forceDelete();
            session()->flash('success', 'Tga Removed Successfully');
        }else{
            $tag->delete();
            session()->flash('success', 'Tag Trashed Successfully');
        }
        return redirect()->route('tags.index');
    }

    public function trashed(){
        $trashed = Tag::onlyTrashed()->get();
        return view('tags.index')->with('tags' , $trashed);
    }

    public function restore($id){
        $tag = Tag::withTrashed()->where('id', $id)->first();
        $tag->restore();
        session()->flash('success', 'Tga Restord Successfully');
        return redirect()->route('tags.index');

    }
}
