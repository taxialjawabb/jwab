
@extends('index')
@section('title','تعديل بيانات الراكب')
@section('content')
<div>
    <div class="row">
        <div class="col-12 mt-5"></div>
        <div class="col-6">
            الاسم: {{$rider->name}}
        </div>
        <div class="col-6">
            الهاتف: {{$rider->phone}}
        </div>
        <div class="col-12 mt-3"></div>
        <div class="col-6">
            حالة العميل الحالية: <span class="alert alert-secondary p-2">{{$rider->state == 'active'?'نشط' : 'محظور'}}</span>
        </div>
        <div class="col-6">
            البريد الإلكترونى: {{$rider->email}}
        </div>
        <div class="col-12 mt-4"></div>
        <div class="col ">تعديل حالة العميل الـى</div>
        <div class="col m-4"></div>
    </div>
    @if($rider->state == 'blocked')
    <a href="{{ url('rider/edit/state/'.$rider->id)}}" class="btn btn-success mb-3"> تحويل حالة العميل إلى نشط</a>
    <p class="alert alert-success ml-6 mr-6">يتمكن العميل من الدخول للتطبيق وعمل رحلات</p>
    @else
    <a href="{{ url('rider/edit/state/'.$rider->id)}}" class="btn btn-danger mb-3 ">حظر العميل </a>
    <p class="alert alert-danger ml-6 mr-6">لا يتمكن العميل من الدخول للتطبيق وعمل رحلات</p>
    @endif
</div>

@endsection

@section('scripts')

@endsection