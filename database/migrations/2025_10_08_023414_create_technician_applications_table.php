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
        Schema::create('technician_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->foreignId("category_id")->constrained("categories")->onDelete("cascade");
            $table->text('skills')->nullable();
            $table->text('experience')->nullable();
            $table->string('cv_file')->nullable(); // مرفق زي السيرة الذاتية أو شهادة
            $table->enum('status', [
                'pending',               // لسه تحت المراجعة
                'accepted',              // تم القبول وإنشاء الحساب
                'rejected'               // مرفوض
            ])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technician_applications');
    }
};
