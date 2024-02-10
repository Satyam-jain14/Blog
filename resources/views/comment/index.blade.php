
@foreach($info as $cmt)
    <div class="mb-1 pb-2 border rounded">
        @if($cmt->cuser)
        <div class="mb-1" style="background-color: rgb(189, 184, 179)">
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