
@extends('index')
@section('title','التحويلات البنكية')
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
            <h5 class=" mt-4 float-start">التحويلات البنكية للعملاء {{ $type ==='refused'? 'المرفوضة' : 'المقبولة' }}</h5>
            <div class="float-end mt-3">        
                <a href="{{url('bank/transfer/rider/show/state/confimed')}}" class="btn  rounded-0 m-0 {{ $type === 'confimed'?  'btn-primary' : 'btn-light' }}" >التحويلات المقبولة </a>
                <a href="{{url('bank/transfer/rider/show/state/refused')}}" class="btn  rounded-0 m-0  {{ $type === 'refused'?   'btn-primary' : 'btn-light' }}" >التحويلات المرفوضة </a>
            </div>
        </div>
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>رقم</th>
                                    <th>اسم العميل</th>
                                    <th>اسم المحول</th>
                                    <th>اسم البنك</th>
                                    <th>صورة التحويل</th>
                                    <th>المبلغ</th>
                                    <th>تاريخ الاضافة</th>                                   
                                    <th>{{ $type ==='refused'? 'رفض' : 'قبول' }}بواسطة</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->person_name }}</td>
                                    <td>{{ $d->bank_name }}</td>
                                    <td>
                                        @if($d->transfer_photo !== null)
                                        <form  method="GET" action="{{ url('show/pdf') }}">
                                            @csrf
                                            <input type="hidden" name="url" value="{{'assets/images/riders/banktransfer/'.$d->transfer_photo}}">
                                            <button type="submit" class="btn btn-light" >عرض المرفق</button>
                                        </form>
                                        @endif
                                    </td>
                                    <td>{{ $d->money  }}</td>
                                    <td>{{ $d->created_at }}</td>
                                    <td>
                                        {{ $d->admin_name }}
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="" alt="المرفق" id="note" style="width:100%; height:380px" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#reject").on('click', function(e){
                if (!confirm('تأكيد رفض طلب التحويل البنكى')) {
                    e.preventDefault();
                    }
            });
        });
    </script>

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
                    "sLengthMenu": "عـرض _MENU_ تحويلات بنكية",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض تحويلات بنكية من _START_ إلى _END_ من إجمالي _TOTAL_ من تحويل",
                    "sInfoEmpty": "عرض تحويلات بنكية من 0 إلى 0 من إجمالي 0 تحويل",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من تحويلات بنكية)",
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