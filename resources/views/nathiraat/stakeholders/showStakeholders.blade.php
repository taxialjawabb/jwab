
@extends('index')
@section('title','الجهات')
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
        <a href="{{url('nathiraat/stakeholders/add')}}" class="btn btn-success rounded-0 m-0" >أضـافـة جهة</a>
    </div>
</div>
<div class="clearfix "></div>
<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>رقم الجهة</th>
                    <th>اسم الجهة</th>
                    <th>تاريخ الأنتهاء</th>
                    <th>تاريخ الأضافة</th>
                    <th>اضيف بواسطة</th>
                    <th>عرض</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $stakeholder)
                <tr>
                    <td>{{ $stakeholder->id }}</td>
                    <td>{{ $stakeholder->name }}</td>
                    <td>{{ $stakeholder->expire_date }}</td>
                    <td>{{ \Carbon\Carbon::parse($stakeholder->add_date)->format('d/m/Y') }}</td>
                    <td>{{ $stakeholder->add_by }}</td>
                    <td>
                        <a href="{{ url('nathiraat/stakeholders/detials/'.$stakeholder->id) }}" class="btn btn-primary">عـرض</a>
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
                    "sLengthMenu": "عـرض _MENU_ الجهات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض الجهات من _START_ إلى _END_ من إجمالي _TOTAL_ من مستخدم",
                    "sInfoEmpty": "عرض الجهات من 0 إلى 0 من إجمالي 0 مستخدم",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من الجهات)",
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