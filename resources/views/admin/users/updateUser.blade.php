
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
  <h3 class="m-2 mt-4">تعديل بيانات مستخدم</h3>
</div>
<form method="POST" action="{{ url('user/update') }}">
  @csrf
  <input type="hidden" name="id" value="{{ $user->id}}">
  <div class="container">
    <div class="row">

    <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="name" class="form-label">اسم المستخدم</label>
        <input type="text" value="{{ $user->name }}" name="name" class="form-control" id="name"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="role_id" class="form-label">حدد دور للمستخدم</label>
          <select value="{{ $user->role_id }}" name="role_id" id="role_id" class="form-select" aria-label="Default select example" id="role_id" required>
            @foreach($roles as $role)
            <option value="{{$role->id}}"  {{ $user->hasRole($role['name']) ? 'selected' : ''}}>{{$role->display_name}}     </option>
            @endforeach
          </select>
      </div>

      
      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="department" class="form-label">القسم </label>
            <select value="{{ old('department') }}" name="department" id="department" class="form-select" aria-label="Default select example" id="department" required>
                <option  disabled >حدد القسم</option>
                <option value="management" {{ $user->department == 'management'? 'selected':''  }}>القسم الإدارى</option>
                <option value="technical" {{ $user->department == 'technical' ? 'selected':''  }}>القسم التقني</option>
            </select>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="phone" class="form-label">رقم الجوال</label>
        <input type="text" value="{{ $user->phone }}" name="phone" class="form-control" id="phone"  required>
      </div>


      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="nationality" class="form-label">الجنسية</label>
        <input type="text" value="{{ $user->nationality }}" name="nationality" class="form-control" id="nationality"  disabled>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="ssd" class="form-label">رقم الهوية</label>
        <input type="text" name="ssd"  value="{{ $user->ssd }}" class="form-control" id="ssd"  disabled>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="password" class="form-label">الرقم السرى للمستخدم</label>
        <input type="password" name="password" class="form-control" id="password">
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="working_hours" class="form-label">عدد ساعات العمل المطلوبة</label>
        <input type="text" name="working_hours"  value="{{ $user->working_hours }}" class="form-control" id="working_hours"  required>
      </div>

      <div class="mt-4 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label for="monthly_salary" class="form-label">الراتب الشهري</label>
        <input type="text" name="monthly_salary"  value="{{ $user->monthly_salary }}" class="form-control" id="monthly_salary"  required>
      </div>

      <!-- <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 "></div> -->

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="date_join" class="form-label">تاريخ الإلتحاق</label>
        <input type="date" value="{{\Carbon\Carbon::parse( $user->date_join )->format('Y-m-d')}}" name="date_join" class="form-control" id="date_join"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="Employment_contract_expiration_date" class="form-label">تاريخ إنتهاء عقد العمل</label>
        <input type="date" value="{{\Carbon\Carbon::parse($user->Employment_contract_expiration_date)->format('Y-m-d') }}" name="Employment_contract_expiration_date" class="form-control" id="Employment_contract_expiration_date"  required>
      </div>

      <div class="mt-4  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="final_clearance_exity_date" class="form-label">تاريخ إنتهاء المخالصة النهاشية</label>
        <input type="date" value="{{ \Carbon\Carbon::parse($user->final_clearance_exity_date)->format('Y-m-d')  }}" name="final_clearance_exity_date" class="form-control" id="final_clearance_exity_date"  required>
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
  <button type="submit" class="btn btn-primary m-4 ">حفظ بيانات المستخدم</button>
</form>
@endsection

@section('scripts')

@endsection