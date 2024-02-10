    @extends('layouts.app')
    @section('content')
@if(Session::get('msg'))
<div class="container bordered">
    <div class="alert alert-info text-center">
    <h3>{{Session::get('msg')}}</h3>
    </div>
</div>
@endif
<div class="container border">
    <div class="row p-2">
        <div class="col-lg-4 col-sm-12 border">
            <div class="col-12 border p-2">
                <div class="text-center mb-5 mt-5">
                    
                        <img src="/profiles/{{$info->profilepic}}" class="rounded-circle" style="height:200px;width:200px" />

                </div>
                <div class="text-center">
                    @if(Auth::user()->id==$info->id)
                    <form action="/userProfile" method="post" enctype="multipart/form-data" id="frm">
                        @csrf
                        <input type="file" name="profilepic" id="profile" hidden accept="image/*" onchange="frm.submit()">
                        <label class="btn btn-primary" for="profile">
                            @if(Auth::user()->profilepic)
                                Change Profile
                            @else
                                Add Profile
                            @endif
                        </label>

                        @error("profilepic")
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-sm-12 border p-2">
            <div class="container">
                <form id="frm1" method="post" action="/user/update/{{$info->id}}">
                @csrf
                    @method('patch')
                <div class="row p-2">
                    <div class="col-1">
                        <b><label for="name" class="p-2">Name:</label></b>
                    </div>
                    <div class="col-11">
                        <input type="text" name="name" id="name" class="form-control editable" required @if($info->name)
                        value="{{$info->name}}"
                        @else
                        value="N/A"
                        @endif readonly>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-1">
                        <b><label for="bio" class="p-2">Bio:</label></b>
                    </div>
                    <div class="col-11">
                        <input type="text" name="bio" id="name" class="form-control editable" required @if($info->bio)
                        value="{{$info->bio}}"
                        @else
                        value="N/A"
                        @endif readonly>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-1">
                        <b><label for="dob" class="p-2">Dob:</label></b>
                    </div>
                    <div class="col-11">
                        <input type="date" name="dob" id="dob" max="{{date('Y-m-d',time()-(86400*365.25*18))}}" class="form-control editable" required @if($info->dob)
                        value="{{$info->dob}}"
                        @endif readonly>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-1">
                        <b><label class="p-2">Status:</label></b>
                    </div>
                    <div class="col-11 p-2">
                        <div class="container">
                            <div class="row">
                                <div class="col-4">
                                    <input type="radio" name="status" id="single" value="single" class="editable" readonly required @if($info->status=='single')
                                    @checked(true)
                                    @endif >
                                    <label for="single">Single</label>
                                </div>
                                
                                <div class="col-4">
                                    <input type="radio" name="status" value="married" id="married" class="editable" readonly required @if($info->status=='married')
                                    @checked(true)
                                    @endif>
                                    <label for="single">Married</label>
                                </div>
                                
                                <div class="col-4">
                                    <input type="radio" name="status" value="commited" id="Commited" class="editable" readonly required @if($info->status=='commited')
                                    @checked(true)
                                    
                                    @endif>
                                    <label for="commited">Commited</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-1">
                        <b><label class="p-2">Gender:</label></b>
                    </div>
                    <div class="col-11 p-2">
                        <div class="container">
                            <div class="row">
                                <div class="col-4">
                                    <input type="radio" name="gender" id="male" class="editable" required @if($info->gender=='male')
                                    @checked(true)
                                    @endif value="male" readonly>
                                    <label for="male">Male</label>
                                </div>
                                
                                <div class="col-4">
                                    <input type="radio" name="gender" value="female" id="female" class="editable" required @if($info->gender=='female')
                                    @checked(true)
                                    @endif readonly>
                                    <label for="single">Female</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->id==$info->id)
                <div class="row p-2">
                    <div class="col-1">
                        <b><label for="name" class="p-2">Email:</label></b>
                    </div>
                    <div class="col-11">
                        <input type="text" name="email" id="email" readonly class="form-control editable" required @if($info->email)
                        value="{{$info->email}}"
                        @else
                        value="N/A"
                        @endif>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-1">
                        <b><label for="mobile" class="p-2">Mobile:</label></b>
                    </div>
                    <div class="col-11">
                        <input type="number" name="mobile" id="mobile" readonly class="form-control editable" required @if($info->mobile)
                        value="{{$info->mobile}}"
                        @else
                        value="N/A"
                        @endif>
                        @error("mobile")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        {{-- <div class="text-danger" id="mobErr" hidden>The mobile must be 10 digits.</div> --}}
                    </div>
                    
                </div>

                <div class="row p-2">
                    <div class="col-1">
                        <b><label for="address" class="p-2">Address:</label></b>
                    </div>
                    <div class="col-11">
                        <textarea name="address" id="address" class="form-control editable" required readonly>
                            @if($info->address)
                                {{$info->address}}
                            @else
                                N/A
                            @endif
                        </textarea>
                    </div>
                </div>
                <div class="row justify-content-center p-2">
                    <div class="col-2"><button id="mybtn" class="btn btn-primary" onclick="read({{$info->id}})">Edit</button></div>
                </div>
                @endif
                </form>
            </div>
        </div>
    </div>
</div>
<script>

    function read(id){
        if(mybtn.innerText=="Edit"){
            $(".editable").removeAttr('readonly');
            mybtn.innerText="Update"
        }
        else{
            // if($("#mobile").val().length==10){
            $("#frm1").submit();
            // }
            // else{
                // $("#mobErr").removeAttr("hidden");
                // return false;
            // }
            // let formData={
            //     name:frm1.name,
            //     bio:frm1.bio,
            //     dob:frm1.dob,
            //     status:frm1.status,
            //     gender:frm1.gender,
            //     email:frm1.email,
            //     mobile:frm1.mobile,
            //     address:frm1.address,
            //     _token:"{{csrf_token()}}"
            // }
            // $.ajax({
            //     url: "user/update/"+id,
            //     type:'patch',
            //     data: formData,
            //     // dataType:"json",
            //     // encode:true,
            //     success:function(data) {
            //         alert("updated")
            //     },
            //     error: function(data){
            //     // console.log(data);
            //     alert("error h")
            //     }
            // });
        }
        return false;
    }
</script>
@endsection