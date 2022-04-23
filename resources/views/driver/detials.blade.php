
@extends('index')
@section('title','بيانات السائق')
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
    <h3 class="m-2 mt-4 float-start">عرض بيانات السائق</h3>
    <div class="float-end mt-4">
    
    @if(Auth::user()->isAbleTo('driver_box'))
    <a href="{{ url('driver/box/show/take/'.$driver->id) }}" class="btn btn-primary rounded-0 m-0">الصندوق</a>
    @endif

    @if(Auth::user()->isAbleTo('driver_document_notes'))
    <a href="{{ url('driver/notes/show/'.$driver->id) }}" class="btn btn-primary rounded-0 m-0">الملاحظات</a>
    <a href="{{ url('driver/documents/show/'.$driver->id) }}" class="btn btn-primary rounded-0 m-0">المستندات</a>
    @endif
    {{--@if($driver->state !=='active')--}}
    <a href="{{ url('driver/take/vechile/'.$driver->id) }}" class="btn btn-primary rounded-0 m-0" >تسليم مركبة</a>
    {{--@endif--}}
    <a href="{{ url('driver/state/'.$driver->id) }}" class="btn btn-primary rounded-0 m-0" >تحويل حالة السائق</a>
    <a href="{{ url('driver/vechile/'.$driver->id) }}" class="btn btn-primary rounded-0 m-0">عرض المركبات المستلمة</a>
    
    <a href="{{ url('driver/vechile/maintenance/'.$driver->id) }}" class="btn btn-primary rounded-0 m-0">الصيانة</a>
    {{--@if($driver->state ==='active')--}}
    <a href="{{ url('covenant/delivery/'.$driver->id) }}" class="btn btn-primary rounded-0 m-0">عرض العهد المستلمة</a>
    {{--@endif--}}
    <a href="{{ url('driver/update/'.$driver->id) }}" class="btn btn-danger rounded-0 m-0">تعديل</a>

  </div>
</div>

  <div class="container">
    <div class="row">
      
    @if($driver->persnol_photo && File::exists('images/drivers/personal_phonto/'.$driver->persnol_photo))
    <div class="text-center-1 image m-1">
        <img src="{{ asset('images/drivers/personal_phonto/'.$driver->persnol_photo)}}" style="width: 80px; height: 100px" id="profile-img-tag" alt="صورة السائق">
    </div>
    @endif

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم السائق</label>
        <p class="alert alert-secondary p-1">{{$driver->name}}</p>
      </div>

      <div class="mt-0 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="phone" class="form-label">الحالة الحالية</label>
        <p class="alert alert-secondary p-1">
        @switch($driver->state)
          @case('active')
              سائق مستلم
              @break
          @case('waiting')
              سائق انتظار
              @break
          @case('blocked')
              سائق مستبعد
              @break
          @default
              Default case...
        @endswitch
        </p>
      </div>
      
      <div class="mt-0 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="phone" class="form-label">رقم الهاتف</label>
        <p class="alert alert-secondary p-1">{{$driver->phone}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="nationality" class="form-label">الجنسية</label>
        <p class="alert alert-secondary p-1">{{$driver->nationality}}</p>
      </div>

      <div class="mt-0 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="address" class="form-label">عنوان السكن</label>
        <p class="alert alert-secondary p-1">{{$driver->address}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="ssd" class="form-label">رقم الهوية</label>
        <p class="alert alert-secondary p-1">{{$driver->ssd}}</p>
      </div>

      <div class="mt-0 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="id_copy_no" class="form-label">رقم نسخة الهوية</label>
        <p class="alert alert-secondary p-1">{{$driver->id_copy_no}}</p>
      </div>

      <div class="mt-0 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="id_expiration_date" class="form-label">تاريخ انتهاء الهوية</label>
        <p class="alert alert-secondary p-1">{{$driver->id_expiration_date}}</p>
      </div>

      <!-- <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div> -->

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="license_type" class="form-label">نوع الرخصة</label>
        <p class="alert alert-secondary p-1">{{$driver->license_type}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="license_expiration_date" class="form-label">تاريخ إنتهاء الرخصة</label>
        <p class="alert alert-secondary p-1">{{$driver->license_expiration_date}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="birth_date" class="form-label">تاريخ الميلاد</label>
        <p class="alert alert-secondary p-1">{{$driver->birth_date}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="start_working_date" class="form-label">تاريخ بداية العمل</label>
        <p class="alert alert-secondary p-1">{{$driver->start_working_date}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="contract_end_date" class="form-label">تاريخ انتهاء عقد العمل</label>
        <p class="alert alert-secondary p-1">{{$driver->contract_end_date}}</p>
      </div>

      <div class="mt-0  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="final_clearance_date" class="form-label">تاريخ انتهاء المخالصة النهائية</label>
        <p class="alert alert-secondary p-1">{{$driver->final_clearance_date}}</p>
      </div>
    </div>
  </div>
  
@if($vechile !== null)

  <h5> بيانات المركبة  الحالية للسائق</h5>

<div class="container">
    <div class="row">
    
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="category_name" class="form-label">التصنيف</label>
        <p class="alert alert-secondary p-1">{{$vechile->category_name}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="category_name" class="form-label">التصنيف الفرعي</label>
        <p class="alert alert-secondary p-1">{{$vechile->name??'لا يوجد'}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="state" class="form-label">حالة المركبة</label>
        <p class="alert alert-secondary p-1">{{$vechile->state}}</p>
      </div>
      
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="vechile_type" class="form-label">نوع المركبة</label>
        <p class="alert alert-secondary p-1">{{$vechile->vechile_type}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="plate_number" class="form-label">رقم لوحة المركبة</label>
        <p class="alert alert-secondary p-1">{{$vechile->plate_number}}</p>
      </div>


      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="made_in" class="form-label">سنة تصنيع المركبة</label>
        <p class="alert alert-secondary p-1">{{$vechile->made_in}}</p>
      </div>

      <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="serial_number" class="form-label">الرقم التسلسلى</label>
        <p class="alert alert-secondary p-1">{{$vechile->serial_number}}</p>
      </div>

      <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="color" class="form-label">لـون المركبة</label>
        <p class="alert alert-secondary p-1">{{$vechile->color}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="driving_license_expiration_date" class="form-label">تاريخ إنتهاء رخصة السير</label>
        <p class="alert alert-secondary p-1">{{$vechile->driving_license_expiration_date}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="periodic_examination_expiration_date" class="form-label">تاريخ إنتهاء الفحص الدورى</label>
        <p class="alert alert-secondary p-1">{{$vechile->periodic_examination_expiration_date}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="insurance_card_expiration_date" class="form-label">تاريخ إنتهاء التأمين</label>
        <p class="alert alert-secondary p-1">{{$vechile->insurance_card_expiration_date}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="operating_card_expiry_date" class="form-label">تاريخ إنتهاء بطاقة التشغيل</label>
        <p class="alert alert-secondary p-1">{{$vechile->operating_card_expiry_date}}</p>
      </div>
      
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="admin_name" class="form-label">تم الأضافة بواسطة</label>
        <p class="alert alert-secondary p-1">{{$vechile->admin_name}}</p>
      </div>
      
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="add_date" class="form-label">تاريخ الإضافة</label>
        <p class="alert alert-secondary p-1">{{$vechile->add_date}}</p>
      </div>

     
    </div>
  </div>
@endif





@endsection

@section('scripts')

@endsection