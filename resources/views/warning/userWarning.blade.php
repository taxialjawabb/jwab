
@extends('index')
@section('title','تنبيهات المستخدمين')
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
    <h5 class=" mt-4 float-start">تنبيهات المستخدمين</h5>

    <div class="float-end mt-3">        
        <a href="{{url('warning/user/Employment_contract_expiration_date')}}" class="btn {{$type === 'Employment_contract_expiration_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء عقد العمل</a>
        <a href="{{url('warning/user/final_clearance_exity_date')}}" class="btn {{$type === 'final_clearance_exity_date' ? 'btn-primary' : 'btn-light'}} rounded-0 m-0" >انتهاء المخالصة النهائية</a>
    </div>
</div>
<div class="clearfix "></div>
<div class="contriner">
    <div id="piechart" style="width: 100%; height: 500px;"></div>
</div>

<div class="panel panel-default mt-4">
    <div class="table-responsive">
        <table class="table " id="datatable">
            <thead>
                <tr>
                    <th>رقم المستخدم</th>
                    <th>اسم المستخدم</th>
                    <th>رقم الجوال</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الايام المتبقية او المنتهية</th>
                    <th>تاريخ الأضافة</th>
                    <th>عرض</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->ended_date }}</td>
                    <td>{{ $user->days }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ url('user/detials/'.$user->id) }}" class="btn btn-primary">عـرض</a>
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
<script type="text/javascript" src="{{ asset('assets/js/charts.js') }}"></script>

@if ($type === 'Employment_contract_expiration_date')
<script>
        var clear = @json($contractClear);
        var remains = @json($contractRemains);
        var expired = @json($contractExpired);
        var title = 'بيانات العقود للمستخدمين';
        var title1 = "العقود السارية";
        var title2 = "العقود متبقى عليها اقل من شهرين";
        var title3 = "العقود المنتهية";
</script>
@elseif ($type === 'final_clearance_exity_date')
<script>
        var clear = @json($clearanceClear);
        var remains = @json($clearanceRemains);
        var expired = @json($clearanceExpired);
        var title = 'بيانات المخالصةالنهائية للمستخدمين';
        var title1 = "المخالصات السارية";
        var title2 = "المخالصات متبقى عليها اقل من شهرين";
        var title3 = "المخالصات المنتهية";
</script>
@endif

<script type="text/javascript">
$(document).ready(function(){
google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Task', 'Hours per Day'],
      [title1, clear],
      [title2 , remains],
      [title3 ,  expired]
    ]);

    var options = {
      title: title,
      legend : {
      display : true,
      position : "right",
            labels: {
                fontSize:16,
                fontColor:'black'
            }
          }
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
    
  }
});
</script>
@endsection