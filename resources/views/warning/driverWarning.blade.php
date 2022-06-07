
@extends('index')
@section('title','السائقين')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start"> تنبيهات السائقين</h5>
    <div class="float-end mt-3">
        <a href="{{url('warning/driver/id_expiration_date')}}" class="btn {{$type === 'id_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء الهوية</a>
        <a href="{{url('warning/driver/license_expiration_date')}}" class="btn {{$type === 'license_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء الرخصة</a>
        <a href="{{url('warning/driver/contract_end_date')}}" class="btn {{$type === 'contract_end_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء عقد العمل</a>
        <a href="{{url('warning/driver/final_clearance_date')}}" class="btn {{$type === 'final_clearance_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء المخالصة النهائية</a>
    </div>
</div>
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم</th>
                                    <th>السائق</th>
                                    <th>الجوال</th>
                                    <th>تاريخ الانتهاء</th>
                                    <th>الايام المتبقية او المنتهية</th>
                                    <th>تاريخ الأضافة</th>
                                    <th></th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drivers as $driver)
                                <tr>
                                    <td>{{ $driver->id }}</td>
                                    <td>{{ $driver->name }}</td>
                                    <td>{{ $driver->phone }}</td>
                                    <td>{{ $driver->ended_date }}</td>
                                    <td>{{ $driver->days }}</td>
                                    <td>{{ $driver->add_date }}</td>
                                    <td>
                                        <a href="{{ url('driver/details/'.$driver->id) }}" class="m-1 btn btn-primary">عرض</a>
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
                "order": {{ 4, "asc" }},
                // dom: 'Blfrtip',
                // buttons: [
                //             { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                //             { extend : 'excel', className : 'btn btn-success text-light' , text : 'Excel' ,charset: "utf-8"},
                //             // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                //             { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                //         ],
                language: {
                    "sProcessing": "جاري التحميل...",
                    "sLengthMenu": "عـرض _MENU_ سائقين",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض سائقين من _START_ إلى _END_ من إجمالي _TOTAL_ من سائق",
                    "sInfoEmpty": "عرض سائقين من 0 إلى 0 من إجمالي 0 سائق",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من سائقين)",
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
@endsection