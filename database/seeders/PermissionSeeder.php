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
        $createPost = Permission::create([
            'name' => 'category_city',
            'display_name' => 'التصنيفات و المدن', // optional
            'description' => 'يستطيع المستخدم الوصول لبيانات التصنيفات و المدن سواء عرض اوأضافة او تعديل عرض السائقين المستلمين تحويل حالة المركبة', // optional
            ]);
            
            $editUser = Permission::create([
            'name' => 'vechile_data',
            'display_name' => 'بيانات المركبات', // optional
            'description' => 'يستطيع المستخدم الوصول لبيانات التصنيفات و المدن سواء عرض او أضافة او تعديل', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'vechile_document_notes',
            'display_name' => 'المستندات و الملاحظات للمركبات', // optional
            'description' => 'يستطيع المستخدم الوصول للمستندات و الملاحظات سواء عرض او أضافة او تعديل', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'vechile_box',
            'display_name' => 'صندوق المركبات', // optional
            'description' => 'يستطيع المستخدم الوصول لصندوق المركبة و عرض و أضافة سند', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'driver_data',
            'display_name' => 'بيانات السائقين', // optional
            'description' => 'يستطيع المستخدم الوصول لبيانات المستخدم سواء عرض او أضافة او تعديل عرض المركبات المستلمة تحويل حالة السائق', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'driver_document_notes',
            'display_name' => 'المستندات و الملاحظات للسائقين', // optional
            'description' => 'يستطيع المستخدم الوصول للمستندات و الملاحظات للسائق سواء عرض او أضافة', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'driver_box',
            'display_name' => 'صندوق السائقين', // optional
            'description' => 'يستطيع المستخدم الوصول لصندوق السائق سواء عرض او أضافة سند', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'rider_data',
            'display_name' => 'بيانات الركاب', // optional
            'description' => 'يستطيع المستخدم الوصول لبيانات الركاب سواء عرض او تعديل حالة الراكب ', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'rider_document_notes',
            'display_name' => 'المستندات و الملاحظات للراكب', // optional
            'description' => 'يستطيع المستخدم الوصول للمستندات و الملاحظات للراكب سواء عرض او أضافة',
            ]);
            $editUser = Permission::create([
            'name' => 'rider_box',
            'display_name' => 'صندوق الراكب', // optional
            'description' => 'يستطيع المستخدم الوصول لصندوق الراكب سواء عرض او اضافة سند', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'requests',
            'display_name' => 'الطلبات', // optional
            'description' => 'يستطيع المستخدم رية الطلبات للرحلات بجيميع حالتها', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'nathiraat_box',
            'display_name' => 'الـنـثـريـات', // optional
            'description' => 'يستطيع المستخدم الوصول لصندوق النثريات سواء عرض او أضافة سند', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'waiting_confirm',
            'display_name' => 'فواتير بإنتظار  التأكيد', // optional
            'description' => 'يستطيع الوصول للفواتير بأنتظار التأكيد و عمل تأكيد على الفواتير', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'waiting_trustworthy',
            'display_name' => 'فواتير بإنتظار الأعتماد', // optional
            'description' => 'يستطيع المستخدم الوصول للفواتير بإنتظار الأعتماد', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'waiting_deposit',
            'display_name' => 'مبالغ بإنتظار الإيداع', // optional
            'description' => 'يستطيع المستخدم الوصول الى المبالغ والفواتير بإنتظار الإيداع وعمل ايداع', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'general_box',
            'display_name' => 'الصندوق العام', // optional
            'description' => 'يستطيع المستخدم الوصول الى الصندوق العام ', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'user_manage',
            'display_name' => 'أدارة المستخدمين', // optional
            'description' => 'يستطيع المستخدم الوصول للمستخدمين و أضافة ادوار و تعديل صلاحيات المستخدمين', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'user_own_tasks',
            'display_name' => 'مستخدم لدية مهام', // optional
            'description' => 'يستطيع المستخدم من الوصول الى المهام الخاصة بيها و اضافة تحديثات لها', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'show_ations_on_system',
            'display_name' => 'الأحداث', // optional
            'description' => 'تمكن المستخدم من روئية الأحداث التى وقعت داخل النظام من عمليات الدخول والاضافة والتعديل', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'manage_tasks',
            'display_name' => 'أدارة المهام', // optional
            'description' => 'يستطيع المستخدم من أدارة المهام للمستخدمين وأضافة مهام وعرضها', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'complete_task',
            'display_name' => 'المهام المكتملة', // optional
            'description' => 'يستطيع المستخدم من روئية المهام المكتملة', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'manage_covenant',
            'display_name' => 'أدارة العهد', // optional
            'description' => 'يستطيع المستخدم من خلالها أدارة العهد', // optional
            ]);
            $editUser = Permission::create([
            'name' => 'user_delivery_covenant',
            'display_name' => 'مستخدم يسلم عهد', // optional
            'description' => 'يستطيع المستخدم من خلالها تسليم العهد للسائقين', // optional
            ]);
    }
}
