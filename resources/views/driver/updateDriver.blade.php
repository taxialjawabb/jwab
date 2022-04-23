
@extends('index')
@section('title','إضافة سائق')
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
  <h3 class="m-2 mt-4">أضافة سائق جديدة</h3>
</div>
<form method="POST" action="{{ url('driver/update') }}" enctype="multipart/form-data">
  @csrf
  <div class="container">
    <div class="row">
    <input type="hidden" name="id" value="{{ $driver->id }}">
      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم السائق</label>
        <input type="text" value="{{ $driver->name }}" name="name" class="form-control" id="name"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="nationality" class="form-label">الجنسية</label>
        <input type="text" value="{{ $driver->nationality }}" name="nationality" class="form-control" id="nationality"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="phone" class="form-label">رقم الهاتف</label>
        <input type="text" name="phone"  value="{{ $driver->phone }}" class="form-control" id="phone"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="address" class="form-label">عنوان السكن</label>
        <input type="text" name="address"  value="{{ $driver->address }}" class="form-control" id="address"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="ssd" class="form-label">رقم الهوية</label>
        <input type="text" value="{{ $driver->ssd }}" name="ssd" class="form-control" id="ssd"  disabled>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="id_copy_no" class="form-label">رقم نسخة الهوية</label>
        <input type="text" name="id_copy_no"  value="{{ $driver->id_copy_no }}" class="form-control" id="id_copy_no"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="id_expiration_date" class="form-label">تاريخ انتهاء الهوية</label>
        <input type="date" value="{{ $driver->id_expiration_date->format('Y-m-d') }}" name="id_expiration_date" class="form-control" id="id_expiration_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="license_type" class="form-label">نوع الرخصة</label>
        <input type="text" value="{{ $driver->license_type }}" name="license_type" class="form-control" id="license_type"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="license_expiration_date" class="form-label">تاريخ إنتهاء الرخصة</label>
        <input type="date" value="{{ $driver->license_expiration_date->format('Y-m-d') }}" name="license_expiration_date" class="form-control" id="license_expiration_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="birth_date" class="form-label">تاريخ الميلاد</label>
        <input type="date" value="{{ $driver->birth_date->format('Y-m-d') }}" name="birth_date" class="form-control" id="birth_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="start_working_date" class="form-label">تاريخ بداية العمل</label>
        <input type="date" style="text-direction:rtl" value="{{ $driver->start_working_date->format('Y-m-d') }}" name="start_working_date" class="form-control" id="start_working_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="contract_end_date" class="form-label">تاريخ انتهاء عقد العمل</label>
        <input type="date" style="text-direction:rtl" value="{{ $driver->contract_end_date->format('Y-m-d') }}" name="contract_end_date" class="form-control" id="contract_end_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="final_clearance_date" class="form-label">تاريخ انتهاء المخالصة النهائية</label>
        <input type="date" style="text-direction:rtl" value="{{ $driver->final_clearance_date->format('Y-m-d') }}" name="final_clearance_date" class="form-control" id="final_clearance_date"  required>
      </div>

      <div class="mb-3 mt-4 ">
        <label for="formFile" class="form-label">صورة شخصية للسائق</label>
        <input class="form-control"type="file" name="image" value="{{old('image')}}"  id="file">
    </div>

   
    @if($driver->persnol_photo)
    <div class="text-center image m-3">
        <img src="{{ asset('images/drivers/personal_phonto/'.$driver->persnol_photo)}}" style="width: 120px; height: 150px" id="profile-img-tag" alt="صورة السائق">
    </div>
    @endif


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
  




  <button type="submit" class="btn btn-primary m-4 ">حفظ بيانات السائق</button>
</form>
@endsection

@section('scripts')
<script src="{{ asset('js/addimg.js') }}" ></script>   
<script>
    $(function(){
    $('#profile-img-tag').show();
});

</script>

@endsection