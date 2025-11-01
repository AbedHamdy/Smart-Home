<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('x', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('technicians')->onDelete('set null');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            // بيانات الطلب
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->enum('status', [
                'pending',               // طلب جديد من العميل
                'assigned',              // تم إسناده لفني
                'in_progress',           // الفني ذهب للمعاينة
                'waiting_for_approval',  // الفني رفع تقرير وسعر الإصلاح وينتظر موافقة العميل
                'approved_for_repair',   // العميل وافق على السعر
                'issue_reported',        // الفني ينتظر وصول قطع الغيار
                'rescheduled',           // تم إعادة الجدولة
                'completed',             // الإصلاح تم بنجاح
                'canceled'
                ])->default('pending');

            $table->timestamp('completed_at')->nullable();

            $table->text('technician_report')->nullable();
            $table->string('issue_type')->nullable();
            $table->timestamp('issue_reported_at')->nullable();
            // $table->decimal('price', 10, 2)->nullable();

            // Price of visit and repair
            $table->decimal('inspection_fee', 10, 2)->nullable(); // سعر الزيارة
            $table->decimal('repair_cost', 10, 2)->nullable();    // سعر التصليح بعد المعاينة
            $table->boolean('client_approved')->nullable();                      // العميل وافق علي التصليح ولا لا

            // الموقع
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
