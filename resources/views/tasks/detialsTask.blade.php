
@extends('index')
@section('title','بيانات مهمة')
@section('content')
<div class="mt-3 mb-3 container clearfix">
  <h4 class=" float-start">بيانات المهمة</h4>
</div>

<div class="clearfix"></div>

<div class="container">
    <div class="row">
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
        <p class="alert alert-secondary p-1">{{$task->readed_date}}</p>
      </div>
      @if($task->finish_date !== null)
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">تاريخ الأنهاء</label>
        <p class="alert alert-secondary p-1">{{$task->finish_date}}</p>
      </div>
      @endif
    </div>

@if(count($results) > 0)
    <h6 >نتائج المهمة</h6>
<div>
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


  </div>


@endsection

@section('scripts')

@endsection