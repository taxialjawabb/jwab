
@extends('index')
@section('title','إضافة دور')
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
  <h3 class="m-1 mt-4">أضافة دور جديد </h3>
</div>
<form method="POST" action="{{ url('user/roles/update') }}">
  @csrf
  <input type="hidden" name="role_id" value="{{$role->id}}">
  <div class="container">
    <div class="row">

      <div class="mt-2  col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
        <label for="display_name" class="form-label">اسم الدور</label>
        <input type="text" value="{{ $role->display_name }}" name="display_name" class="form-control" id="display_name"  disabled>
      </div>

      <div class="row">
        <div class="mb-1 col-sm-12 col-lg-6">
            <label for="description" class="col-form-label">الـوصــف:</label>
            <textarea name="description"  value="{{ $role->description }}"  class="form-control" id="description" disabled>{{ $role->description }}</textarea>
        </div>
    </div>
    <div class="container border border-primary border-1  rounded-3 mt-4 p-3">
        <div class="row">

            @foreach($permissions as $permission)
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <div class="form-check mt-2">
                    <input class="form-check-input" name="id[]" type="checkbox" value="{{$permission->id}}" id="{{$permission->name}}"  {{ $role->hasPermission($permission['name']) ? 'checked' : ''}}>
                    <label class="form-check-label text-dark" for="{{$permission->name}}">
                        {{$permission->display_name}}
                    </label>
                </div>
            </div>
            @endforeach

        </div>
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
  <button type="submit" class="btn btn-primary m-4 ">حفظ الدور</button>
</form>
@endsection

@section('scripts')

@endsection