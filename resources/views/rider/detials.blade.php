
@extends('index')
@section('title','بيانات العميل')
@section('content')
<div class="mt-3 mb-3 container clearfix">
  <h4 class=" float-start">بيانات العميل</h4>
  <div class="float-end mt-3">
        @if(Auth::user()->isAbleTo('rider_box'))
        <a href="{{ url('rider/box/show/take/'.$rider->id) }}" class="btn btn-primary rounded-0 m-0">الصندوق</a>
        @endif

        @if(Auth::user()->isAbleTo('rider_document_notes'))
        <a href="{{ url('rider/documents/show/'.$rider->id) }}" class="btn btn-primary rounded-0 m-0">المستندات</a>
        <a href="{{ url('rider/notes/show/'.$rider->id) }}" class="btn btn-primary rounded-0 m-0">الملاحظات</a>
        @endif
        
        <a href="{{ url('rider/edit/'.$rider->id)}}" class="btn btn-success text-light ">تعديل</a>
        <a href="{{ url('rider/trips/'.$rider->id)}}" class="btn btn-success text-light bg-primary" >الرحلات</a>
    </div>
</div>

<div class="container">
    <div class="row">
    
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="category_name" class="form-label">الأسم</label>
        <p class="alert alert-secondary p-1">{{$rider->name}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="state" class="form-label">الهاتف</label>
        <p class="alert alert-secondary p-1">
            {{ $rider->phone}}
        </p>
      </div>
      
      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="vechile_type" class="form-label">الإيميل</label>
        <p class="alert alert-secondary p-1">{{$rider->email ?? null}}</p>
      </div>

      <div class="  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="plate_number" class="form-label">حالة العميل</label>
        <p class="alert alert-secondary p-1">{{$rider->state == 'active'? 'نشط':'موقوف'}}</p>
      </div>


    </div>
  </div>
 
@endsection

@section('scripts')

@endsection