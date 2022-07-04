<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     *               php artisan db:seed --class=PermissionSeeder
     * 
     *
     * @return void
     */
    public function run()
    {
        // $createPost = Permission::create([
        //     'name' => 'category_city',
        //     'display_name' => 'التصنيفات و المدن', // optional
        //     'description' => 'يستطيع المستخدم الوصول لبيانات التصنيفات و المدن سواء عرض اوأضافة او تعديل عرض السائقين المستلمين تحويل حالة المركبة', // optional
        //     ]);
            
        //     $editUser = Permission::create([
        //     'name' => 'vechile_data',
        //     'display_name' => 'بيانات المركبات', // optional
        //     'description' => 'يستطيع المستخدم الوصول لبيانات التصنيفات و المدن سواء عرض او أضافة او تعديل', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'vechile_document_notes',
        //     'display_name' => 'المستندات و الملاحظات للمركبات', // optional
        //     'description' => 'يستطيع المستخدم الوصول للمستندات و الملاحظات سواء عرض او أضافة او تعديل', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'vechile_box',
        //     'display_name' => 'صندوق المركبات', // optional
        //     'description' => 'يستطيع المستخدم الوصول لصندوق المركبة و عرض و أضافة سند', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'driver_data',
        //     'display_name' => 'بيانات السائقين', // optional
        //     'description' => 'يستطيع المستخدم الوصول لبيانات المستخدم سواء عرض او أضافة او تعديل عرض المركبات المستلمة تحويل حالة السائق', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'driver_document_notes',
        //     'display_name' => 'المستندات و الملاحظات للسائقين', // optional
        //     'description' => 'يستطيع المستخدم الوصول للمستندات و الملاحظات للسائق سواء عرض او أضافة', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'driver_box',
        //     'display_name' => 'صندوق السائقين', // optional
        //     'description' => 'يستطيع المستخدم الوصول لصندوق السائق سواء عرض او أضافة سند', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'rider_data',
        //     'display_name' => 'بيانات الركاب', // optional
        //     'description' => 'يستطيع المستخدم الوصول لبيانات الركاب سواء عرض او تعديل حالة الراكب ', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'rider_document_notes',
        //     'display_name' => 'المستندات و الملاحظات للراكب', // optional
        //     'description' => 'يستطيع المستخدم الوصول للمستندات و الملاحظات للراكب سواء عرض او أضافة',
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'rider_box',
        //     'display_name' => 'صندوق الراكب', // optional
        //     'description' => 'يستطيع المستخدم الوصول لصندوق الراكب سواء عرض او اضافة سند', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'requests',
        //     'display_name' => 'الطلبات', // optional
        //     'description' => 'يستطيع المستخدم رية الطلبات للرحلات بجيميع حالتها', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'nathiraat_box',
        //     'display_name' => 'الـنـثـريـات', // optional
        //     'description' => 'يستطيع المستخدم الوصول لصندوق النثريات سواء عرض او أضافة سند', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'waiting_confirm',
        //     'display_name' => 'فواتير بإنتظار  التأكيد', // optional
        //     'description' => 'يستطيع الوصول للفواتير بأنتظار التأكيد و عمل تأكيد على الفواتير', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'waiting_trustworthy',
        //     'display_name' => 'فواتير بإنتظار الأعتماد', // optional
        //     'description' => 'يستطيع المستخدم الوصول للفواتير بإنتظار الأعتماد', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'waiting_deposit',
        //     'display_name' => 'مبالغ بإنتظار الإيداع', // optional
        //     'description' => 'يستطيع المستخدم الوصول الى المبالغ والفواتير بإنتظار الإيداع وعمل ايداع', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'general_box',
        //     'display_name' => 'الصندوق العام', // optional
        //     'description' => 'يستطيع المستخدم الوصول الى الصندوق العام ', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'user_manage',
        //     'display_name' => 'أدارة المستخدمين', // optional
        //     'description' => 'يستطيع المستخدم الوصول للمستخدمين و أضافة ادوار و تعديل صلاحيات المستخدمين', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'user_own_tasks',
        //     'display_name' => 'مستخدم لدية مهام', // optional
        //     'description' => 'يستطيع المستخدم من الوصول الى المهام الخاصة بيها و اضافة تحديثات لها', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'show_ations_on_system',
        //     'display_name' => 'الأحداث', // optional
        //     'description' => 'تمكن المستخدم من روئية الأحداث التى وقعت داخل النظام من عمليات الدخول والاضافة والتعديل', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'manage_tasks',
        //     'display_name' => 'أدارة المهام', // optional
        //     'description' => 'يستطيع المستخدم من أدارة المهام للمستخدمين وأضافة مهام وعرضها', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'complete_task',
        //     'display_name' => 'المهام المكتملة', // optional
        //     'description' => 'يستطيع المستخدم من روئية المهام المكتملة', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'manage_covenant',
        //     'display_name' => 'أدارة العهد', // optional
        //     'description' => 'يستطيع المستخدم من خلالها أدارة العهد', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'user_delivery_covenant',
        //     'display_name' => 'مستخدم يسلم عهد', // optional
        //     'description' => 'يستطيع المستخدم من خلالها تسليم العهد للسائقين', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'import_export',
        //     'display_name' => 'صادر و وارد', // optional
        //     'description' => 'يستطيع المستخدم من خلالها عرض الصادر والوارد و اضافة جديده للصادر والوارد', // optional
        //     ]);
        //     $editUser = Permission::create([
        //     'name' => 'stakeholders',
        //     'display_name' => 'الجهات', // optional
        //     'description' => 'يستطيع المستخدم من خلالها عرض الجهات وأضافة جهة جديدة ', // optional
        //     ]);
                // $editUser = Permission::create([
                // 'name' => 'driver_reports',
                // 'display_name' => 'تقرير السائق ', // optional
                // 'description' => 'يستطيع المستخدم من خلالها عرض اجمالى القبض للسائق خلال فترة معينة', // optional
                // ]);
                // $editUser = Permission::create([
                // 'name' => 'driver_debits',
                // 'display_name' => 'السائقين المتعثرين', // optional
                // 'description' => 'يستطيع المستخدم من خلالها عرض السائقين المتعثرين والمتخالفين عن دفع مبلغ معين ', // optional
                // ]);
                // $editUser = Permission::create([
                // 'name' => 'warning_driver',
                // 'display_name' => 'تنبيهات السائقين ', // optional
                // 'description' => 'يستطيع المستخدم من خلالها عرض تنبيهات للسائقين عن تاريخ انتهاء الهوية و انتهاء الرخصةو انتهاء عقد العمل و المخالصة النهائية', // optional
                // ]);
                // $editUser = Permission::create([
                // 'name' => 'warning_vechile',
                // 'display_name' => 'تنبيهات المركبات', // optional
                // 'description' => 'يستطيع المستخدم من خلالها عرض تنبيهات المركبات عن انتهاء رخصة السير و انتهاء الفحص الدورى و انتهاء التأمين و انتهاء بطاقة التشغيل ', // optional
                // ]);
                // $editUser = Permission::create([
                // 'name' => 'warning_user',
                // 'display_name' => 'تنبيهات المستخدمين ', // optional
                // 'description' => 'يستطيع المستخدم من خلالها عرض تنبيهات المستخدمين عن انتهاء عقد العمل و تاريخ المخالصة النهائية', // optional
                // ]);
                // $editUser = Permission::create([
                //     'name' => 'maintenance_center',
                //     'display_name' => 'مركز الصيانة' , // optional
                //     'description' => 'يستطيع المستخدم من خلالها متابعة بيانات مركز الصيانة واضافة منتاجة و صيانة للسائقين', // optional
                //     ]);
                // $editUser = Permission::create([
                //     'name' => 'add_task',
                //     'display_name' => 'أضافة مهمة' , // optional
                //     'description' => 'يستطيع المستخدم من خلالها أضافة مهمة جديدة', // optional
                //     ]);
                // $editUser = Permission::create([
                //     'name' => 'add_task',
                //     'display_name' => 'أضافة مهمة' , // optional
                //     'description' => 'يستطيع المستخدم من خلالها أضافة مهمة جديدة', // optional
                //     ]);
                // $editUser = Permission::create([
                //     'name' => 'direct_task',
                //     'display_name' => 'توجيه المهام' , // optional
                //     'description' => 'يستطيع المستخدم من خلالها توجيه المهمه الى مستخدم محدد او تغير الشخص المسؤال عن المهمة', // optional
                //     ]);
                $editUser = Permission::create([
                    'name' => 'show_driver_take',
                    'display_name' => 'عرض السائقين المستلمين ' , // optional
                    'description' => 'يستطيع المستخدم من خلالها عرض السائقين المقيدين بالفعل بالنظام', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'show_driver_waiting',
                    'display_name' => 'عرض السائقين المنتظرين' , // optional
                    'description' => 'يستطيع المستخدم من خلالها عرض السائقين المنتظرين الذين ليس بحوزتهم مركبة', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'show_driver_blocked',
                    'display_name' => 'عرض السائقين المستبعدين' , // optional
                    'description' => 'يستطيع المستخدم من خلالها عرض السائقين المستعدين من النظام', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'new_driver',
                    'display_name' => 'السائقين المسجل حديثا' , // optional
                    'description' => 'يستطيع المستخدم من خلالها عرض السائقين المسجل حديثا', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'add_driver',
                    'display_name' => 'أضافة سائق' , // optional
                    'description' => 'يستطيع المستخدم من خلالها أضافة سائق جديد للنظام', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'add_maintenance_center',
                    'display_name' => 'أضافة صيانة المركز' , // optional
                    'description' => 'يستطيع المستخدم من خلالها أضافة صيانة للسائق من خلال مركز الصيانة الخاص بنا', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'show_maintenance_center',
                    'display_name' => 'عرض صيانة المركز' , // optional
                    'description' => 'يستطيع المستخدم من خلالها عرض الصيانات بالمركز الخاص بنا', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'covenant_show',
                    'display_name' => 'عرض العهد' , // optional
                    'description' => 'يستطيع المستخدم من خلالها عرض العهد لدى السائق', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'covenant_add',
                    'display_name' => 'أضافة عهد للسائق' , // optional
                    'description' => 'يستطيع المستخدم من خلالها أضافة عهد للسائق', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'vechile_recieved',
                    'display_name' => 'عرض المركبات المستلمة' , // optional
                    'description' => 'يستطيع المستخدم من خلالها عرض المركبات المستلمة', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'change_state_driver',
                    'display_name' => 'تحويل  حالة السائق' , // optional
                    'description' => 'يستطيع المستخدم من خلالها', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'driver_take_vechile',
                    'display_name' => 'تسليم مركبة للسائق' , // optional
                    'description' => 'يستطيع المستخدم من خلالها', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'maintenance_outdoor',
                    'display_name' =>  'الصيانات الخارجية للسائق' , // optional
                    'description' => 'يستطيع المستخدم من خلالها عرض الصيانات الخارجية للسائق', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'user_show',
                    'display_name' => 'عرض المستخدمين' , // optional
                    'description' => 'يستطيع المستخدم من خلالها عرض المستخدمين للنظام', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'user_add',
                    'display_name' => 'أضافة مستخدم' , // optional
                    'description' => 'يستطيع المستخدم من خلالها أضافة مستخدم جديد', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'user_box',
                    'display_name' => 'صندوق المستخدم' , // optional
                    'description' => 'يستطيع المستخدم من خلالها روئية الصندوق الخاص بالمستخدم', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'user_note',
                    'display_name' => 'ملاحظات المستخدم' , // optional
                    'description' => 'يستطيع المستخدم من خلالها عرض المستندات الخاصة بالمستخدم ', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'user_document',
                    'display_name' => 'مستندات المستخدم' , // optional
                    'description' => 'يستطيع المستخدم من خلالها عرض المستندات الخاصة بالمستخدم', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'user_state',
                    'display_name' => 'استبعاد المستخدم' , // optional
                    'description' => 'يستطيع المستخدم من خلالها أضافة صلاحية لمستخدم', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'user_role',
                    'display_name' => 'أضافة دور للمستخدم' , // optional
                    'description' => 'يستطيع المستخدم من خلالها أضافة دور للمستخدم', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'role_add',
                    'display_name' => 'أضافة دور' , // optional
                    'description' => 'يستطيع المستخدم من خلالها', // optional
                    ]);
                $editUser = Permission::create([
                    'name' => 'role_update',
                    'display_name' => 'تعديل دور' , // optional
                    'description' => 'يستطيع المستخدم من خلالها', // optional
                    ]);
                
                        
    }
}
