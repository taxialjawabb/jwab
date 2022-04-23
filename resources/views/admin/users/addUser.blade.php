
@extends('index')
@section('title','إضافة مستخدم')
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
  <h3 class="m-2 mt-4">أضافة مستخدم جديد</h3>
</div>
<form method="POST" action="{{ url('user/add') }}">
  @csrf
  <div class="container">
    <div class="row">

    <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم المستخدم</label>
        <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="name"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="role_id" class="form-label">حدد دور للمستخدم</label>
          <select value="{{ old('role_id') }}" name="role_id" id="role_id" class="form-select" aria-label="Default select example" id="role_id" required>
            @foreach($roles as $role)
            <option value="{{$role->id}}">{{$role->display_name}}</option>
            @endforeach
          </select>
      </div>
      
      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="department" class="form-label">القسم </label>
            <select value="{{ old('department') }}" name="department" id="department" class="form-select" aria-label="Default select example" id="department" required>
                <option selected disabled>حدد القسم</option>
                <option value="management">القسم الإدارى</option>
                <option value="technical">القسم التقني</option>
            </select>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label">رقم الجوال</label>
        <input type="text" value="{{ old('phone') }}" name="phone" class="form-control" id="phone"  required>
      </div>


      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="nationality" class="form-label">الجنسية</label>
        <input type="text" value="{{ old('nationality') }}" name="nationality" class="form-control" id="nationality"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="ssd" class="form-label">رقم الهوية</label>
        <input type="text" name="ssd"  value="{{ old('ssd') }}" class="form-control" id="ssd"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="password" class="form-label">الرقم السرى للمستخدم</label>
        <input type="password" name="password"  value="{{ old('password') }}" class="form-control" id="password"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="working_hours" class="form-label">عدد ساعات العمل المطلوبة</label>
        <input type="text" name="working_hours"  value="{{ old('working_hours') }}" class="form-control" id="working_hours"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="monthly_salary" class="form-label">الراتب الشهري</label>
        <input type="text" name="monthly_salary"  value="{{ old('monthly_salary') }}" class="form-control" id="monthly_salary"  required>
      </div>

      <!-- <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div> -->

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="date_join" class="form-label">تاريخ الإلتحاق</label>
        <input type="date" value="{{ old('date_join') }}" name="date_join" class="form-control" id="date_join"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="Employment_contract_expiration_date" class="form-label">تاريخ إنتهاء عقد العمل</label>
        <input type="date" value="{{ old('Employment_contract_expiration_date') }}" name="Employment_contract_expiration_date" class="form-control" id="Employment_contract_expiration_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="final_clearance_exity_date" class="form-label">تاريخ إنتهاء المخالصة النهاشية</label>
        <input type="date" value="{{ old('final_clearance_exity_date') }}" name="final_clearance_exity_date" class="form-control" id="final_clearance_exity_date"  required>
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
  <button type="submit" class="btn btn-primary m-4 ">حفظ بيانات المركبة</button>
</form>
@endsection

@section('scripts')

@endsection