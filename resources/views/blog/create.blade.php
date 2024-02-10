@extends('layouts.app')
@section('content')
        
            <form action="/blog" method="post" enctype="multipart/form-data" id="frm">
                @csrf
            <div class="container">
                <div class="alert alert-primary">New Blog Form</div>
                
                <div class="mb-3">
                        <label for="title" class="p-2">Blog title:</label>
                        <input type="text" name="title" id="title" class="form-control" required >
                </div>

                <div class="mb-3">
                        <label for="image">Add Image</label>
                        <input type="file" name="image" class="form-control" id="image" accept="image/*">
                        @error("profilepic")
                        <div class="text-danger">{{$message}}</div>
                        @enderror

                </div>
                
                <div class="mb-3">
                    <label for="category" class="p-2">Category:</label>
                    <input type="text" name="category" id="category" class="form-control" required>
                </div>
                
                <div class="mb-3">
                        <label for="summary" class="p-2">Summary:</label>
                        <input type="text" name="summary" id="summary" class="form-control" required>
                </div>

                <div class="mb-3">
                        <label for="blog_content" class="p-2">Content:</label>
                        <textarea name="blog_content" class="form-control " id="blog_content"></textarea>
                </div>
                
                <div class="row justify-content-center p-2">
                    <div class="col-2"><button id="mybtn" class="btn btn-primary">Save</button></div>
                </div>
                </form>
            </div>
        </div>


@endsection