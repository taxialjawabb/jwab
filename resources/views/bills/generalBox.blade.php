
@extends('index')
@section('title','الصندوق العام')
@section('content')
<div class="container clearfix">
    <h5 class=" mt-4 float-start">الـصـنـدوق الــعــام</h5>
</div>
<div class="clearfix "></div>
<div class="container">
    <div class="clearfix">
        <div class="float-start">  
            <h6 style="margin: 10px">
                إجمالي القبض
            </h6>
            <div  class="bg-warning m-2 text-center p-2 ">
                {{$generalBox->take ?? 0}}
            </div>
        </div>
        <div class="float-start">  
            <h6 style="margin: 10px">
                إجمالي الصرف
            </h6>
            <div  class="bg-warning m-2 text-center p-2 ">
                {{$generalBox->spend ?? 0}}
            </div>
        </div>
        <div class="float-start text-center">  
            <h6 style="margin: 10px">
                الأجــمــالـــي
            </h6>
            <div  class="bg-warning m-2 text-center p-2 ">
                {{$generalBox->account ?? 0}}
            </div>
        </div>
    </div>
</div>
                <div class="panel panel-default mt-4">
                        <div class="table-responsive">
                            <table class="table " id="datatable">
                                <thead>
                                    <tr>
                                        <th>اسم المودع</th>
                                        <th>تاريخ الأيداع </th>
                                        <th>رقم الحساب البنكي</th>
                                        <th>نـوع السند</th>
                                        <th>المبلغ</th>
                                        <th>عدد الفواتير</th>
                                        <th>طريقة الدفع</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deposits as $depoisted)
                                    <tr>
                                        <td>{{ $depoisted->name}}</td>
                                        <td>{{ $depoisted->deposit_date}}</td>
                                        <td>{{ $depoisted->bank_account_number}}</td>
                                        <td>
                                        @switch($depoisted->bond_type)
                                            @case('spend')
                                                صــرف
                                                @break
                                            @case('take')
                                                قـبــض
                                                @break
                                            @default
                                            
                                        @endswitch
                                        </td>
                                        <td>{{ $depoisted->money}}</td>
                                        <td>{{ $depoisted->count_bill}}</td>
                                        <td>
                                        @switch($depoisted->payment_type)
                                            @case('cash')
                                                كــاش
                                                @break
                                            @case('bank transfer')
                                                تحويل بنكى
                                                @break
                                            @case('internal transfer')
                                                تحويل داخلى
                                                @break
                                            @case('selling points')
                                                نقاط بيع
                                                @break
                                            @case('electronic payment')
                                                دفع إلكترونى
                                                @break
                                            @default
                                                
                                        @endswitch
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
                // 'lengthMenu' : [[10,25,50,100, -1],[10,25,50,100, 'All Rider']],
                // dom: 'Blfrtip',
                // buttons: [
                //             { extend : 'csv'  , className : 'btn btn-success text-light' , text : 'CSV' ,charset: "utf-8" },
                //             { extend : 'excel', className : 'btn btn-success text-light' , text : 'Excel' ,charset: "utf-8"},
                //             // { extend : 'pdf'  , className : 'btn btn-success text-light' , text : 'PDF' ,charset: "utf-8" },
                //             { extend : 'print', className : 'btn btn-success text-light' , text : 'Print' ,charset: "utf-8"},
                //         ],
                language: {
                    "sProcessing": "جاري التحميل...",
                    "sLengthMenu": "عـرض _MENU_ الفواتير",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض الفواتير من _START_ إلى _END_ من إجمالي _TOTAL_ من فاتورة",
                    "sInfoEmpty": "عرض الفواتير من 0 إلى 0 من إجمالي 0 فاتورة",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من الفواتير)",
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

        $(document).ready(function(){
            var selectAll = false ;
            $("#confirm-all").click(function(e){
                e.preventDefault();
                
                if(selectAll == false){
                    selectAll = true;
                    $(this).text('إلغاء التحديد للجميع');
                    $("#datatable input").attr('checked','checked');
                }else{
                    $(this).html('تحديد الجميع');
                    selectAll = false;
                    $("#datatable input").removeAttr('checked');

                }
            });
        });
    </script>
@endsection