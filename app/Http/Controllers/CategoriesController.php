<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index')->with('categories' , Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // $request->validate([
        //     'name' => 'required|unique:categories'
        // ]);

        // Category::create([
        //     "name" => $request->name
        // ]);

        Category::create($request->all());
        session()->flash('success', 'Categroy Created Successfully');
        return redirect(route('categories.index'));
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
    public function edit(Category $category)
    {
        return view('categories.create')->with('category' , $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
        ]);
        session()->flash('success', 'Categroy Updated Successfully');
        return redirect()->route('categories.index');
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

        $category = Category::withTrashed()->where('id', $id)->first();
        if($category->trashed()){
            $category->forceDelete();
            session()->flash('success', 'Categroy Removed Successfully');
        }else{
            $category->delete();
            session()->flash('success', 'Categroy Trashed Successfully');
        }
        return redirect()->route('categories.index');
    }

    public function trashed(){
        $trashed = Category::onlyTrashed()->get();
        return view('categories.index')->with('categories' , $trashed);
    }

    public function restore($id){
        $category = Category::withTrashed()->where('id', $id)->first();
        $category->restore();
        session()->flash('success', 'Categroy Restord Successfully');
        return redirect()->route('categories.index');

    }
}
