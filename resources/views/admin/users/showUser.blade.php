
@extends('index')
@section('title','المستخدمين')
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
    <div class="float-end mt-3">        
        <a href="{{url('user/add')}}" class="btn btn-success rounded-0 m-0" >أضـافـة مستخدم</a>
    </div>
</div>
<div class="clearfix "></div>
<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>رقم المستخدم</th>
                    <th>اسم المستخدم</th>
                    <th>رقم الجوال</th>
                    <th>الادوار</th>
                    <th>تاريخ الأضافة</th>
                    <th>اضيف بواسطة</th>
                    <th>عرض</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        @foreach($user->roles as $roles)
                                {{ $roles->display_name }}
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                    <td>{{ $user->add_by }}</td>
                    <td>
                        <a href="{{ url('user/detials/'.$user->id) }}" class="btn btn-primary">عـرض</a>
                        <a href="{{ url('user/update/'.$user->id) }}" class="btn btn-danger">تعديل</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@endsection

@section('scripts')
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                // dom: 'Blfrtip',
                // buttons: [
                //             { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                //             { extend : 'excel', className : 'btn btn-success text-light' , text : 'Excel' ,charset: "utf-8"},
                //             // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                //             { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                //         ],
                language: {
                    "sProcessing": "جاري التحميل...",
                    "sLengthMenu": "عـرض _MENU_ المستخدمين",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض المستخدمين من _START_ إلى _END_ من إجمالي _TOTAL_ من مستخدم",
                    "sInfoEmpty": "عرض المستخدمين من 0 إلى 0 من إجمالي 0 مستخدم",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من المستخدمين)",
                    "sInfoPostFix": "",
                    "sSearch": "بـحــث:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "التحميل...",
                    "oPaginate": {
                        "sFirst": "الأول",
                        "sLast": "الأخير",
                        "sNext": "التالى",
                        "sPrevious": "السابق"
                    },
                    "oAria": {
                        "sSortAscending": ": التفعيل لفرز العمود بترتيب تصاعدي",
                        "sSortDescending": ": التفعيل لفرز العمود بترتيب تنازلي"
                    }
                }
            });

           $('#datatable_length').addClass('mb-3');
        });
        </script>
        <script src="{{ asset('js/imgmodel.js') }}" ></script>   
@endsection