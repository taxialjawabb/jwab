
@extends('index')
@section('title','العهد')
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
    <h3 class="m-2 mt-4 float-start">عرض العهد</h3>
    <div class="float-end mt-4">
    <a href="{{url('covenant/add')}}" class="btn btn-success rounded-0 m-0" >أضـافـة عهده جديد</a>
  </div>
</div>
    <div class="panel panel-default mt-4">
        <div class="table-responsive">
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th># </th>
                        <th>  اسم العهدة</th>
                        <th>  العدد</th>
                        <th>تم الاضافة بواسطة</th>
                        <th> تاريخ الإضافة</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($covenants as $covenant)
                    <tr class="covenat{{$covenant->id}}">
                        <td class="id">{{ $covenant->id }}</td>
                        <td class="name">{{ $covenant->covenant_name }}</td>
                        <td >{{ $covenant->counts }}</td>
                        <td>{{ $covenant->add_by }}</td>
                        <td>{{ $covenant->add_date }}</td>
                        <td>
                            <a href="{{ url('covenant/item/show/'.$covenant->covenant_name) }}" class="btn btn-primary">عرض</a>
                            <a href="#" class="btn covenant btn-success"   id="covenat{{$covenant->id}}" data-bs-toggle="modal" data-bs-target="#exampleModal">أضافة عنصر</a>
                            <!-- <a href="{{ url('vechile/update/cagegory/'.$covenant->id) }}" class="btn btn-danger">تعديل</a> -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="container-fluid mt-1 element-center" id="printable">
            <p  class="mb-1 mt-3 pt-1 text-center "  style="color: black; font-size: 16px;">أضافة عهد * <span id="covenant-name"></span> *  </p>
            <form  method="POST" action="{{ url('covenant/item/delivery/add') }}" id='form'>
                <input type="hidden" class="covenant_name" name="covenant_name" required>
                @csrf
                <p >الارقام التسلسلية</p>
                <div class="container mycontainer">

                </div>
               <div class="row">
                <div class="mt-2  col" id="end">
                        <label for="number" class="form-label">عدد العهد المراد ادخالها</label>
                        <input type="text" name="counter" class="form-control" id="number"  required>
                    </div>
                

                    <div class="mt-4  col">
                        <a type="button" id="add-col" href="#" class="btn mt-3 mb-3 btn-primary ">اضافة ارقام تلسلية ليها</a>
                    </div>
               </div>
                <button type="submit" id="save-form" class="btn btn-primary mt-3 mb-3 ">حفظ </button>
            </form>
        </div>  
    </div>
  </div>
</div>
@endsection 

@section('scripts')

<script>
    $(function() {
        $("#save-form").hide();
        $('#add-col').on('click', function(){
            $("#save-form").show();
            var count = $("#end input").val();
           if(count != null ){
            $(".mycontainer").html('');
            for (let index = 0; index < count; index++) {
                $(".mycontainer").append('<div class="mt-3"><input type="text" name="serial[]" class="form-control"  ></div>');
                
            }
           }
        });

    var listItem = $(".covenant");
    for(var i =0 ; i < listItem.length; i++){
        listItem[i].addEventListener('click', function(e){
            var id = $("."+e.target.id+" .id").text();
            var name = $("."+e.target.id+" .name").text();
            $("#covenant-name").text(name);
            $(".covenant_name").val(name);
        }); 
    }
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
                    "sLengthMenu": "عـرض _MENU_ العهد",
                    "sZeroRecords": "لم يتم العثور على نتائج",
                    "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                    "sInfo": "عرض العهد من _START_ إلى _END_ من إجمالي _TOTAL_ من عهده",
                    "sInfoEmpty": "عرض العهد من 0 إلى 0 من إجمالي 0 عهده",
                    "sInfoFiltered": "(تصفية إجمالي _MAX_ من العهد)",
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