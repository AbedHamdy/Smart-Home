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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('technicians')->onDelete('set null');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            // بيانات الطلب
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'canceled'])->default('pending');
            $table->timestamp('completed_at')->nullable();
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
