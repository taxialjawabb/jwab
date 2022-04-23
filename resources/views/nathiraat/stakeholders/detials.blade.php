
@extends('index')
@section('title','عرض بيانات جهة')
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
    <h4 class=" float-start">بيانات الجهة </h4>
    <div class="float-end mt-4">
     
      <a href="{{ url('nathiraat/stakeholders/box/show/take/'.$stakeholder->id) }}" class="btn btn-primary rounded-0 m-0">الصندوق</a>
      <a href="{{ url('nathiraat/stakeholders/notes/show/'.$stakeholder->id) }}" class="btn btn-primary rounded-0 m-0">الملاحظات</a>
      <a href="{{ url('nathiraat/stakeholders/documents/show/'.$stakeholder->id) }}" class="btn btn-primary rounded-0 m-0">المستندات</a>
  </div>
</div>

<div class="container">
    <div class="row">
      
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم الجهة المستفيدة</label>
        <p class="alert alert-secondary p-1">{{$stakeholder->name}}</p>
      </div>

      <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="date_join" class="form-label">رقم السيجل</label>
        <p class="alert alert-secondary p-1">{{$stakeholder->number_record?? 'لا يوجد'}}</p>
      </div>

      <div class=" col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="Employment_contract_expiration_date" class="form-label">تاريخ الأنتهاء</label>
        <p class="alert alert-secondary p-1">{{$stakeholder->add_date}}</p>
      </div>
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div>
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="final_clearance_exity_date" class="form-label">تاريخ الأضافة</label>
        <p class="alert alert-secondary p-1">{{$stakeholder->add_date}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="working_hours" class="form-label">أضيف بواسطة</label>
        <p class="alert alert-secondary p-1">{{$stakeholder->add_by}}</p>
      </div>
    </div>
  </div>
 

  @endsection

@section('scripts')

@endsection