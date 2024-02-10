@extends('layouts.app')
@section('content')
@foreach ($data as $info)

<div id="blog_no_{{$info->id}}" class="container mb-3 shadow-lg rounded">
        <div class="row rounded p-1 bg-secondary">
            <a href="userProfile/{{$info->user->id}}" style="text-decoration:none;color:white">
                <img src="/profiles/{{($info->user->profilepic)}}" class="rounded-circle" style="height:25px;width:30px">
                {{$info->user->name}}
            </a>
        </div>
        <div class="p-2">
            Title : <span class="text-muted p-2 blog_{{$info->id}}" title="{{$info->title}}">{{(strlen($info->title)>10)?substr($info->title,0,10)."...":$info->title}}</span> (<a href="" style="color:red;text-decoration:none"> {{ucfirst(strtolower($info->category))}} </a>)
            @if($info->user->id==Auth::user()->id)
            <span style="float:right">    
                <button class="btn btn-primary" id="edit_{{$info->id}}" onclick="return editBlog({{$info->id}})">Edit</button>
                <button class="btn btn-danger" id="delete_{{$info->id}}" onclick="return deleteBlog({{$info->id}})">Delete blog</button>
            </span>
                @endif
        </div>
        <div ondblclick="like($('#likes_{{$info->id}}'),{{$info->id}})" class="row">
            @if($info->image)
            <img src="/images/{{$info->image}}" style="height:500px; width:500px" alt="">
            @endif
        </div>
        <div class="row p-2" style="background:whitesmoke">
            <span class="p-0">Summary :<span  class="p-2 blog_{{$info->id}}">{{ucfirst($info->summary)}}</span></span>
        </div>
        <div class="row p-2" style="background:whitesmoke">
        <span class="p-0">Content :<span  class="p-2 blog_{{$info->id}}">{{ucfirst($info->blog_content)}}</span></span>
        </div>
        <div class="row p-2">
            <div class="col-2">
                <div class="row">
                    <div class="col-2">
                        <i id='likes_{{$info->id}}' onclick="like($(this),{{$info->id}})" class="fa-heart
                            @if(in_array(Auth::user()->id,array_column(array_map(fn($r)=>(array)$r,json_decode($info->tlikes)),'user_id')))
                             fa-solid
                             @else
                             fa-regular
                             @endif
                             " style="color: #ff0000;"></i>
                        (<span id="like_{{$info->id}}" >{{count($info->tlikes)}}</span>)

                    </div>

                    <div class="col-2">
                        <i onclick="$('#cmt_{{$info->id}}').slideToggle(500)" class="fa-regular fa-comment" style="color: #b4bac5;"></i>(<span id="comment_{{$info->id}}" >{{count($info->comments)}}</span>)
                    </div>
                </div>
            </div>
            <div class="mb-3" id="cmt_{{$info->id}}" style="display:none">
                {{-- <form action=""> --}}
                    {{-- @csrf --}}
                    <input type="text" value="{{$info->id}}" hidden>
                    <input type="text" value="{{Auth::user()->id}}" hidden>
                    <textarea class="form-control" name="comment"  rows="2" placeholder="Comment..."></textarea>
                    <div class="mb-5">
                        <div class="float-end mt-2 pt-1">
                            <button type="button" onclick="ajaxfun('cmt_{{$info->id}}',{{$info->id}})" class="btn btn-primary btn-sm">Post comment</button>
                            <button type="button" class="btn btn-outline-primary btn-sm">Cancel</button>
                        </div>
                    </div>
                    <div style="max-height:500px;overflow:auto;" id="commentlist_{{$info->id}}">
                        @foreach($info->comments as $cmt)
                        <div class="mb-1 pb-2 border rounded">
                            @if($cmt->cuser->name==Auth::user()->name || $info->user->name==Auth::user()->name)
                            <span class="rounded" style="padding:0px 5px 2px;float:right;color:aliceblue;background-color:#ff0000" onclick="delcmt({{$cmt->id}},{{$info->id}})">Delete</span>
                            @endif
                            @if($cmt->cuser)
                            <div class="mb-1 rounded" style="background-color: rgb(189, 184, 179)">
                            <a href="#" style="text-decoration:none;color:black">
                                <img src="/profiles/{{($cmt->cuser->profilepic)}}" class="rounded-circle" style="height:25px;width:30px">
                                {{$cmt->cuser->name}} 
                            </a>
                            </div>
                            @endif
                            <div class="container">
                                {{$cmt->comment}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                {{-- </form> --}}
                
            </div>
        </div>
    </div>
@endforeach
@endsection
<script>
    function delcmt(cmt_id,blog_id){
        // alert(cmt_id)
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/comment/"+cmt_id,
            method: 'delete',

                success:function(response)
                {
                    loadComment(blog_id)
                }
            })
    }
    function deleteBlog(id){
        // alert(id)
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/blog/"+id,
            method: 'delete',

                success:function(response)
                {
                    $('#blog_no_'+id).fadeOut('slow');
                }
            })
    }
    
    function editBlog(blog_id){
        alert("hi")
        if($(".blog_"+blog_id)[0].hasAttribute("contenteditable")){
            data={
                title:$(".blog_"+blog_id).eq(0).attr('title'),
                summary:$(".blog_"+blog_id).eq(1).text(),
                blog_content:$(".blog_"+blog_id).eq(2).text(),
                // _token: "{{ csrf_token() }}"

            }
            // console.log(data)
            $.ajax({
                url: "/blog/"+blog_id+"/edit",
                method: 'get',
                data: data,
                success:function(response)
                {
                    alert("Content edited")
                    $(".blog_"+blog_id).removeAttr('contenteditable');
                    $("#edit_"+blog_id).text("Edit")
                }
            })

        }else{
            $(".blog_"+blog_id).attr('contenteditable','true');
            $("#edit_"+blog_id).text("Done")
            alert("You can now make changes in the content")

        }
        return false;
    }
    function like(thisobj,id){
        if(thisobj.hasClass("fa-solid")){

            $.ajax({
                url:"/like/1",
                method:"delete",
                data:{
                    user_id:document.getElementById("cmt_"+id).children[1].value,
                    blog_id:id,
                    _token: "{{ csrf_token() }}"

                },
                success:function(response)
                    {
                        thisobj.removeClass("fa-solid")
                        thisobj.addClass("fa-regular")
                        // $("#like_"+id).
                        $("#like_"+id).html(parseInt($("#like_"+id).html())-1)
                    }
            })


            
        }else{
            // let user_id=document.getElementById("cmt_"+id).children[1].value
            $.ajax({
                url:"/like",
                method:"post",
                data:{
                    user_id:document.getElementById("cmt_"+id).children[1].value,
                    blog_id:id,
                    _token: "{{ csrf_token() }}"

                },
                success:function(response)
                    {
                        thisobj.addClass("fa-solid")
                        thisobj.removeClass("fa-regular")
                        $("#like_"+id).html(parseInt($("#like_"+id).html())+1)
                    }
            })
            
        }
    }
    
    function ajaxfun(cmtid,id){
        
        if(document.getElementById(cmtid).children[2].value=="")
        return
        let data={
            blog_id:document.getElementById(cmtid).children[0].value,
            user_id:document.getElementById(cmtid).children[1].value,
            comment:document.getElementById(cmtid).children[2].value,
            _token: "{{ csrf_token() }}"
        }
        $.ajax({
            url: "/comment",
            method: 'POST',
            data: data,
            success:function(response)
            {
                // alert(id)
                loadComment(id)
            },
            error: function(response) {
            }
        });
    }
    function loadComment(id) {
        $("#commentlist_"+id).html("Loading...")
        // alert("/comment/"+id)

        $.ajax({
            url: "/comment/"+id,
            method: 'GET',
            success:function(response)
            {
                // alert("finnaly hogya")
                $("#commentlist_"+id).html(response)
                $("textarea").val("")
                $("#comment_"+id).html(parseInt($("#comment_"+id).html())+1)

                
                
            },
            error: function(response) {
                console.log(response)
            }
        });
    }
</script>