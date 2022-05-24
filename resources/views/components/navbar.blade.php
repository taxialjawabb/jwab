            <nav class='slider' style="width:260px">
                <div class="flex-shrink-0 p-3 bg-light" style="width: 260px; min-height: 800px;">
                    <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                    <svg class="bi " width="30" height="24"><use xlink:href="#bootstrap"/></svg>
                    <span class="fs-5 fw-semibold">الجواب للنقل البري</span>
                    </a>
                    <ul class="list-unstyled ps-3">
                    @if(Auth::user()->isAbleTo('rider_data'))
                    <li class="mb-1">
                        <a class="btn rider align-items-center rounded collapsed" href="{{url('rider/show')}}" class="link-dark rounded margin-second"> العمـلاء </a>
                    </li>
                    @endif

                    @if(Auth::user()->isAbleTo('driver_data'))
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#driver-all" style="color: rgba(0, 0, 0, .65) ; background-color: transparent !important;" aria-expanded="true">
                        السائقين
                        </button>
                        <div class="collapse show" id="driver-all">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li class="mb-1">
                                <a  class="btn rider align-items-center rounded collapsed" href="{{url('driver/show')}}" class="link-dark rounded"> السائقين</a>
                            </li>
                        
                            @if(Auth::user()->isAbleTo('driver_data'))
                            <li class="mb-1">
                                <a  class="btn rider align-items-center rounded collapsed" href="{{url('driver/records/notes')}}" class="link-dark rounded">ملاحظات السائقين</a>
                            </li>                            
                            @endif
                            
                            @if(Auth::user()->isAbleTo('driver_reports'))
                            <li class="mb-1">
                                <a  class="btn rider align-items-center rounded collapsed" href="{{url('driver/reports/show')}}" class="link-dark rounded">تقرير السائقين</a>
                            </li>
                            @endif

                            @if(Auth::user()->isAbleTo('driver_debits'))
                            <li class="mb-1">
                                <a  class="btn rider align-items-center rounded collapsed" href="{{url('driver/debits')}}" class="link-dark rounded">السائقين المتعثرين</a>
                            </li>
                            @endif
                            
                        </ul>
                        </div>
                    </li>
                    @endif
                   
                    
                    @if(Auth::user()->isAbleTo('vechile_data') || Auth::user()->isAbleTo('category_city'))
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#vechile-all" style="color: rgba(0, 0, 0, .65) ; background-color: transparent !important;" aria-expanded="true">
                        المركبات
                        </button>
                        <div class="collapse show" id="vechile-all">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        @if(Auth::user()->isAbleTo('vechile_data'))
                        <li class="mb-1">
                            <a  class="btn rider align-items-center rounded collapsed" href="{{url('vechile/show')}}" class="link-dark rounded">عرض المركبـات</a>
                        </li>
                        @endif
                        
                        @if(Auth::user()->isAbleTo('category_city'))
                        <li class="mb-1">
                            <a  class="btn rider align-items-center rounded collapsed" href="{{url('vechile/show/cagegory')}}" class="link-dark rounded">عــرض التصنيفات</a>
                        </li>                            
                        @endif
                        </ul>
                        </div>
                    </li>
                    @endif

                    @if(Auth::user()->isAbleTo('requests'))
                    <li class="mb-1">
                        <button class="btn btn-toggle  btn-toggle-second  align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#order-all" aria-expanded="false">
                        الطـلـبـات  
                        </button>
                        <div class="collapse  margin-second" id="order-all">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <!-- enum('request','inprogress','canceled','rejected','expired','reserve') -->
                            <li><a href="{{url('requests/expired')}}" class="link-dark rounded">طلبات تم تنفيذها</a></li>
                            <li><a href="{{url('requests/request')}}" class="link-dark rounded">طلبات قيد الإنتظار</a></li>
                            <li><a href="{{url('requests/inprogress')}}" class="link-dark rounded">طلبات تعمل حاليا</a></li>
                            <li><a href="{{url('requests/rejected')}}" class="link-dark rounded">طلبات تم رفضها من السائق</a></li>
                            <li><a href="{{url('requests/canceled')}}" class="link-dark rounded">طلبات تم إلغاءها من العميل</a></li>
                        </ul>
                        </div>
                    </li>
                    @endif

                    {{-- @if(Auth::user()->isAbleTo('user_manage'))
                    <li class="mb-1">
                        <button class="btn btn-toggle btn-toggle-second align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#support" aria-expanded="false">
                        الدعم الفني
                        </button>
                        <div class="collapse " id="support">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                        <li class="mb-1">
                            <a  class="btn rider align-items-center rounded collapsed" href="{{ url('user/show') }}" class="link-dark rounded">الدعم للعملاء</a>
                        </li>
                        
                        <li class="mb-1">
                            <a  class="btn rider align-items-center rounded collapsed" href="{{ url('user/roles/show') }}" class="link-dark rounded">الدعم للسائقين</a>
                        </li>                            
                            
                        </ul>
                        </div>
                    </li>
                    @endif  --}}
                    
                    <li class="border-top my-1"></li>                    
                    @if(Auth::user()->isAbleTo('waiting_confirm') || Auth::user()->isAbleTo('waiting_trustworthy') || Auth::user()->isAbleTo('waiting_deposit') || Auth::user()->isAbleTo('general_box'))
                    <li class="mb-1">
                        <button class="btn btn-toggle  btn-toggle-second  align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#bill-all" aria-expanded="false">
                        الفواتيــر 
                        </button>
                        <div class="collapse " id="bill-all">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            
                            @if(Auth::user()->isAbleTo('waiting_confirm'))
                            <li><a href="{{ url('bills/waiting/confrim/vechile') }}" class="link-dark rounded">فواتير بانتظار التأكيد </a></li>
                            @endif

                            @if(Auth::user()->isAbleTo('waiting_trustworthy'))
                            <li><a href="{{ url('bills/waiting/trustworthy/vechile') }}" class="link-dark rounded">فواتير بأنتظار الإعتماد </a></li>
                            @endif

                            @if(Auth::user()->isAbleTo('waiting_deposit'))
                            <li><a href="{{ url('bills/waiting/deposit/vechile') }}" class="link-dark rounded">مالغ بانتظار الإيداع </a></li>
                            @endif

                            @if(Auth::user()->isAbleTo('general_box'))
                            <li><a href="{{ url('general/box') }}" class="link-dark rounded">الصندوق العام</a></li>
                            @endif

                        </ul>
                        </div>
                    </li>
                    @endif
                    
                    @if(Auth::user()->isAbleTo('user_manage'))
                    <li class="mb-1">
                        <button class="btn btn-toggle btn-toggle-second align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#users-all" aria-expanded="false">
                        المستخدمين
                        </button>
                        <div class="collapse " id="users-all">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                        <li class="mb-1">
                            <a  class="btn rider align-items-center rounded collapsed" href="{{ url('user/show') }}" class="link-dark rounded">عرض المستخدمين</a>
                        </li>
                        
                        <li class="mb-1">
                            <a  class="btn rider align-items-center rounded collapsed" href="{{ url('user/roles/show') }}" class="link-dark rounded">الأدوار والصلاحيات</a>
                        </li>                            
                            
                        </ul>
                        </div>
                    </li>
                    @endif

                    <li class="border-top my-1"></li>

                    @if(Auth::user()->isAbleTo('nathiraat_box'))
                    <li class="mb-1">
                        <a  class="btn rider align-items-center rounded collapsed" href="{{ url('nathiraat/box/show/take') }}" class="link-dark rounded">
                            عرض النثريــات 
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->isAbleTo('stakeholders'))
                    
                    <li class="mb-1">
                        <a  class="btn rider align-items-center rounded collapsed" href="{{ url('nathiraat/stakeholders/show') }}" class="link-dark rounded">الجهات</a>
                    </li>                            
                        
                    @endif

                    @if(Auth::user()->isAbleTo('import_export'))
                    <li class="mb-1">
                        <a class="btn rider align-items-center rounded collapsed" href="{{url('import/export/show/import')}}" class="link-dark rounded margin-second"> صادر و وارد </a>
                    </li>
                    @endif

                    <li class="border-top my-1"></li>
                    
                    @if(Auth::user()->isAbleTo('user_manage'))
                    <li class="mb-1">
                        <a  class="btn rider align-items-center rounded collapsed" href="{{ url('tasks/show/unseen') }}" class="link-dark rounded">
                            أدارة المهام                        
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->isAbleTo('user_own_tasks'))
                    <li class="mb-1">
                        <a  class="btn rider align-items-center rounded collapsed" href="{{ url('tasks/user/show/unseen') }}"  class="link-dark rounded">
                            مهام القسم                          
                        </a>
                    </li>
                    @endif
                    
                    @if(Auth::user()->isAbleTo('manage_covenant'))
                    <li class="mb-1">
                        <a  class="btn rider align-items-center rounded collapsed" href="{{ url('covenant/show') }}"  class="link-dark rounded">
                            أدارة العهد                           
                        </a>
                    </li>
                    @endif

                    <li class="mb-1">
                        <a class="btn rider align-items-center rounded collapsed" href="{{url('logout')}}" class="link-dark rounded margin-second"> تسجيل الخروج</a>
                    </li>
                    </ul>
                </div>
            </nav>