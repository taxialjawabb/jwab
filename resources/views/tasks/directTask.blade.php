
@extends('index')
@section('title','إضافة مهمة')
@section('content')

@if(Session::has('status'))
<div class="alert alert-success m-3" role="alert">
    {{ Session::get('status')}}
</div>
@endif
@if(Session::has('error'))
<div class="alert alert-danger m-3">
    {{ Session::get('error')}}
</div>
@endif
<div class="container">
    <h3 class="m-2 mt-4">أضافة مهمة جديد</h3>
</div>
<div class="container">
    <div class="row">
        <form method="POST" action="{{ url('tasks/direct') }}">
            @csrf
            <input type="hidden" name="task_id" value="{{ $task->id }}">
            <input type="hidden" name="type" value="{{ $task->type }}">

        <div class="row">
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="department" class="form-label">القسم الموجه له المهمة</label>
                    <select value="{{ old('department') }}" name="department" id="department" class="form-select" aria-label="Default select example" id="department" required>
                        <option selected disabled>حدد القسم</option>
                        <option value="management">القسم الإدارى</option>
                        <option value="technical">القسم التقني</option>
                    </select>
            </div>
            
            <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="user" class="form-label">موجهة الي</label>
                    <select value="{{ old('user_id') }}" name="user_id" id="user" class="form-select" aria-label="Default select example" id="user" required></select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3 mb-1">حفظ </button>
    </form>
    <div class="m-3"></div>
    <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">الموضوع</label>
        <p class="alert alert-secondary p-1">{{$task->subject}}</p>
      </div>
      
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">الموضوع</label>
        <p class="alert alert-secondary p-1">{{$task->content}}</p>
      </div>
      
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">تاريخ القراءة</label>
        <p class="alert alert-secondary p-1">{{$task->readed_date??'غير مقروءة'}}</p>
      </div>

    </div>
</div>
@if ($errors->any())
<div class="alert alert-danger m-3 mt-4">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif



@if(count($results) > 0)
<div class="container">
    <h6 class="mt-2 mb-3" >نتائج المهمة</h6>
    <div class="row">
        @foreach($results as $index=>$result)
            @if($index ===0)
            <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="name" class="form-label">النتائخ</label>
                <p class="alert alert-secondary p-1">{{$result->content}}</p>
            </div>
            <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <label for="name" class="form-label">تاريخ الأضافة</label>
                <p class="alert alert-secondary p-1">
                {{ $result->add_date }}
                </p>
            </div>
            @else
            <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <p class="alert alert-secondary p-1">{{$result->content}}</p>
            </div>
            <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <p class="alert alert-secondary p-1">
                {{ $result->add_date }}
                </p>
            </div>
            @endif
        @endforeach
    </div>
  </div>
@endif

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
      $(document).on("change", '#department', function(){
        var department = $(this).val();
        var op = " ";
        $.ajax({
          type: 'get',
          url: '{!!URL::to("tasks/user/department")!!}',
          data: {'department':department},
          success: function(data){

            // op += '<option value="0" selected disabled> اختر التصنيف الفرعي</option>';
            for(var i =0 ; i < data.length; i++){
              op += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            $("#user").html(op);
          },
          error:function(e){
            console.log('error');
            console.log(e);
          }
        });
      });
    });
  </script>
@endsection