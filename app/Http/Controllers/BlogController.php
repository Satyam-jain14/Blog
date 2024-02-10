<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user=Auth::user();
        $data=Blog::with(['user','comments','tlikes'])->orderBy('id','DESC')->get();
        return view("blog.index",compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("blog.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->image){
            request()->validate([
                'image'=>'required|mimes:jpg,jpge,png,gif|max:5000'
            ]);
            if(request()->image->getError()==0){
                $filename=time()."__".request()->image->getClientOriginalName();
                request()->image->move("./images/",$filename);
            }
        }else{
            $filename="";
        }

        Blog::create([
            'title' => $request->title,
            'image' => $filename,
            'category' => $request->category,
            'user_id' => Auth::user()->id,
            'summary' => $request->summary,
            'blog_content' => $request->blog_content,
        ]);

        return redirect('/blog');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
        $data=Blog::with(['user','comments','tlikes'])->where("user_id",$blog->id)->orderBy('id','DESC')->get();
        return view("blog.index",compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $info=Blog::find($blog->id);
        
        $info->title=request('title');
        $info->summary=request('summary');
        $info->blog_content=request('blog_content');
        $info->save();
        return "hello";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $info=Blog::where('id',$blog->id)->delete();
        return;
    }
}
