
@extends('index')
@section('title','عرض بيانات مستخدم')
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

  <div class="container clearfix">
    <h4 class=" float-start">بيانات المستخدم </h4>
    <div class="float-end mt-4">
      @if($user->state === "active")
        <a href="{{ url('user/block/'.$user->id) }}" class="btn btn-danger rounded-0 m-0">استبعاد</a>
      @else
        <a href="{{ url('user/block/'.$user->id) }}" class="btn btn-dark rounded-0 m-0">إلغاء الأستبعاد</a>
      @endif
      <a href="{{ url('user/box/show/take/'.$user->id) }}" class="btn btn-primary rounded-0 m-0">الصندوق</a>
      <a href="{{ url('user/notes/show/'.$user->id) }}" class="btn btn-primary rounded-0 m-0">الملاحظات</a>
      <a href="{{ url('user/documents/show/'.$user->id) }}" class="btn btn-primary rounded-0 m-0">المستندات</a>
  </div>
</div>

<div class="container">
    <div class="row">
      
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">الاســم</label>
        <p class="alert alert-secondary p-1">{{$user->name}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label">رقم الجوال</label>
        <p class="alert alert-secondary p-1">{{$user->phone}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label"> الـصـلاحـيـات</label>
        <p class="alert alert-secondary p-1">
          @foreach($user->allPermissions() as $index=>$p)
          {{$p->display_name}} 
          {{  $index+1 < $user->allPermissions()->count() ? ' , ': ' '}}
          @endforeach
        </p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label"> الأدوار</label>
        <p class="alert alert-secondary p-1">
          @foreach($user->roles as $role)
          {{$role->display_name}}
          @endforeach
        </p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="ssd" class="form-label">رقم الهوية</label>
        <p class="alert alert-secondary p-1">{{$user->ssd}}</p>
      </div>

      <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="date_join" class="form-label">تاريخ الإلتحاق</label>
        <p class="alert alert-secondary p-1">{{$user->date_join}}</p>
      </div>

      <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="Employment_contract_expiration_date" class="form-label">تاريخ انتهاء عقد العمل</label>
        <p class="alert alert-secondary p-1">{{$user->Employment_contract_expiration_date}}</p>
      </div>

      <!-- <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div> -->

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="final_clearance_exity_date" class="form-label">تاريخ انتهاء تصريح العمل</label>
        <p class="alert alert-secondary p-1">{{$user->final_clearance_exity_date}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="working_hours" class="form-label">عدد ساعات العمل</label>
        <p class="alert alert-secondary p-1">{{$user->working_hours}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="monthly_salary" class="form-label">الراتب الشهرى</label>
        <p class="alert alert-secondary p-1">{{$user->monthly_salary}}</p>
      </div>

    </div>
  </div>
 

  @endsection

@section('scripts')

@endsection