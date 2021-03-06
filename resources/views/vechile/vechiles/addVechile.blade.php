
@extends('index')
@section('title','إضافة مركبة')
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
  <h3 class="m-2 mt-4">أضافة مركبة جديدة</h3>
</div>
<form method="POST" action="{{ url('vechile/add') }}">
  @csrf
  <div class="container">
    <div class="row">
      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="main-category" class="form-label">حدد نوع التصنيف</label>
          <select value="{{ old('category_id') }}" name="category_id" id="main-category" class="form-select" aria-label="Default select example" id="category_id" required>
          <option value="0" selected disabled> حدد التصنيف </option>
          @foreach($cat as $category)
            <option value="{{$category->id}}">{{$category->category_name}}</option>
            @endforeach
          </select>
      </div>
      
      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="secondary-category" class="form-label">حدد التصنيف الفرعي</label>
          <select value="{{ old('secondary_id') }}" name="secondary_id" id="secondary-category" class="form-select" aria-label="Default select example" id="secondary_id" required>
            <option value="0" selected disabled> اختر التصنيف الفرعي</option>
          </select>
      </div>


      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="vechile_type" class="form-label">نوع المركبة</label>
        <input type="text" value="{{ old('vechile_type') }}" name="vechile_type" class="form-control" id="vechile_type"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="plate_number" class="form-label">رقم لوحة المركبة</label>
        <input type="text" value="{{ old('plate_number') }}" name="plate_number" class="form-control" id="plate_number"  required>
      </div>


      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="made_in" class="form-label">سنة تصنيع المركبة</label>
        <input type="text" value="{{ old('made_in') }}" name="made_in" class="form-control" id="made_in"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="serial_number" class="form-label">الرقم التسلسلى</label>
        <input type="text" name="serial_number"  value="{{ old('serial_number') }}" class="form-control" id="serial_number"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="color" class="form-label">لـون المركبة</label>
        <input type="text" value="{{ old('color') }}" name="color" class="form-control" id="color"  required>
      </div>

      <!-- <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div> -->

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="driving_license_expiration_date" class="form-label">تاريخ إنتهاء رخصة السير</label>
        <input type="date" value="{{ old('driving_license_expiration_date') }}" name="driving_license_expiration_date" class="form-control" id="driving_license_expiration_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="periodic_examination_expiration_date" class="form-label">تاريخ إنتهاء الفحص الدورى</label>
        <input type="date" value="{{ old('periodic_examination_expiration_date') }}" name="periodic_examination_expiration_date" class="form-control" id="periodic_examination_expiration_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="insurance_card_expiration_date" class="form-label">تاريخ إنتهاء التأمين</label>
        <input type="date" value="{{ old('insurance_card_expiration_date') }}" name="insurance_card_expiration_date" class="form-control" id="insurance_card_expiration_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="operating_card_expiry_date" class="form-label">تاريخ إنتهاء بطاقة التشغيل</label>
        <input type="date" style="text-direction:rtl" value="{{ old('operating_card_expiry_date') }}" name="operating_card_expiry_date" class="form-control" id="operating_card_expiry_date"  required>
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
  <script type="text/javascript">
    $(document).ready(function(){
      $(document).on("change", '#main-category', function(){
        var main_category = $(this).val();
        var op = " ";
        $.ajax({
          type: 'get',
          url: '{!!URL::to("vechile/secondary/category")!!}',
          data: {'id':main_category},
          success: function(data){
            // op += '<option value="0" selected disabled> اختر التصنيف الفرعي</option>';
            for(var i =0 ; i < data.length; i++){
              op += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            $("#secondary-category").html(op);
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