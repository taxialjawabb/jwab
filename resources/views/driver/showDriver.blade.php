
@extends('index')
@section('title','السائقين')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">{{ $title }}</h5>
    <div class="float-end mt-3">
        <a href="{{url('driver/show')}}" class="btn {{$title == 'عرض بيانات السائقين' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >جميع السائقين</a>
        <a href="{{url('driver/show/blocked')}}" class="btn {{$title == 'عرض بيانات السائقين المستبعد' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >السائقين المستبعده</a>
        <a href="{{url('driver/show/active')}}" class="btn {{$title == 'عرض بيانات السائقين المستلم' ? 'btn-primary' : 'btn-light'}} btn-primary rounded-0 m-0" >السائقين المستلم</a>
        <a href="{{url('driver/show/waiting')}}" class="btn {{$title == 'عرض بيانات السائقين المنتظر' ? 'btn-primary' : 'btn-light'}} btn-primary rounded-0 m-0" >السائقين المنتظر</a>
        <a href="{{url('driver/show/pending')}}" class="btn {{$title == 'عرض بيانات السائقين المسجل حديثا' ? 'btn-primary' : 'btn-light'}} btn-primary rounded-0 m-0" >السائقين المسجل حديثا</a>
        <a href="{{url('driver/availables')}}" class="btn btn-success rounded-0 m-0" >السائقين المتاحيين</a>
        <a href="{{url('driver/add')}}" class="btn btn-success rounded-0 m-0" >أضـافـة سائق جديد</a>
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
                                    <th>نوع المركبة</th>
                                    <th>سنة الصنع</th>
                                    <th>رقم اللوحة</th>
                                    <th>التقيم</th>
                                    <th>تاريخ الأضافة</th>
                                    <th>أضيف بواسطة</th>
                                    <th></th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drivers as $driver)
                                <tr>
                                    <td>{{ $driver->id }}</td>
                                    <td>{{ $driver->name }}</td>
                                    <td>{{ $driver->phone }}</td>
                                    <td>{{ $driver->vechile_type }}</td>
                                    <td>{{ $driver->made_in }}</td>
                                    <td>{{ $driver->plate_number }}</td>
                                    <td>{{ $driver->rate }}</td>
                                    <td>{{ $driver->add_date }}</td>
                                    <td>{{ $driver->admin_name }}</td>
                                    <td>
                                        <a href="{{ url('driver/details/'.$driver->id) }}" class="btn btn-primary">عرض</a>
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