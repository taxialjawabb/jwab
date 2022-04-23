
@extends('index')
@section('title','المستندات')
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
    <h5 class=" mt-4 float-start">عرض المستندات</h5>
    <div class="float-end mt-3">        
        <a href="{{url('rider/documents/add/'.$rider->id)}}" class="btn btn-success rounded-0 m-0" >أضـافـة مستند</a>
    </div>
</div>
                <div class="panel panel-default mt-4">
                    <div class="table-responsive">
                        <table class="table " id="datatable">
                            <thead>
                                <tr>
                                    <th>نوع المستند</th>
                                    <th>الموضوع</th>
                                    <th>المرفق</th>
                                    <th>اضيفة بواسطة</th>
                                    <th>تاريخ الاضافة</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                <tr>
                                    <td>{{ $document->document_type }}</td>
                                    <td>{{ $document->content }}</td>
                                    <td>
                                        <form  method="GET" action="{{ url('show/pdf') }}">
                                            @csrf
                                            <input type="hidden" name="url" value="{{'assets/images/riders/documents/'.$document->attached}}">
                                            <button type="submit" class="btn btn-light" >عرض المرفق</button>
                                        </form>
                                    </td>
                                    <td>{{ $document->admin_name }}</td>
                                    <!-- <td>{{ \Carbon\Carbon::parse($document->add_date)->format('d/m/Y') }}</td> -->
                                    <td>{{ $document->add_date }}</td>
                                    
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
        <img src="" alt="المرفق" id="document" style="width:100%; height:380px" >
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
                    "sLengthMenu": "عـرض _MENU_ المستندات",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض المستندات من _START_ إلى _END_ من إجمالي _TOTAL_ من مستند",
                    "sInfoEmpty": "عرض المستندات من 0 إلى 0 من إجمالي 0 مستند",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من المستندات)",
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