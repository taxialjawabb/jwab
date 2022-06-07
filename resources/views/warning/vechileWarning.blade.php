
@extends('index')
@section('title',' تنبيهات المركبات')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">تنبيهات المركبات</h5>
    <div class="float-end mt-3">        
        <a href="{{url('warning/vechile/driving_license_expiration_date')}}" class="btn {{$type === 'driving_license_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء رخصة السير</a>
        <a href="{{url('warning/vechile/insurance_card_expiration_date')}}" class="btn {{$type === 'insurance_card_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء التأمين</a>
        <a href="{{url('warning/vechile/periodic_examination_expiration_date')}}" class="btn {{$type === 'periodic_examination_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء الفحص الدورى</a>
        <a href="{{url('warning/vechile/operating_card_expiry_date')}}" class="btn {{$type === 'operating_card_expiry_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء بطاقة التشغيل</a>
    </div>
</div>
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم </th>
                                    <th>النوع</th>
                                    <th>سنة الصنع</th>
                                    <th>رقم اللوحة</th>
                                    <th>تاريخ الانتهاء</th>
                                    <th>الايام المتبقية او المنتهية</th>
                                    <th>اضيفة بواسطة</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vechiles as $vechile)
                                <tr>
                                    <td>{{ $vechile->id }}</td>
                                    <td>{{ $vechile->vechile_type }}</td>
                                    <td>{{ $vechile->made_in }}</td>
                                    <td>{{ $vechile->plate_number }}</td>
                                    <td>{{ $vechile->ended_date }}</td>
                                    <td>{{ $vechile->days }}</td>
                                    <td>{{ $vechile->add_date}}</td>
                                    <td>
                                        <a href="{{ url('vechile/details/'.$vechile->id) }}" class="btn btn-primary">عرض</a>
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
                    "sLengthMenu": "عـرض _MENU_ المركبات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض المركبات من _START_ إلى _END_ من إجمالي _TOTAL_ من مركبة",
                    "sInfoEmpty": "عرض المركبات من 0 إلى 0 من إجمالي 0 مركبة",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من المركبات)",
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