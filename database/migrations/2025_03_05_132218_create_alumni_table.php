<?php

use App\Models\Company;
use App\Models\Profession;
use App\Models\Superior;
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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->string('study_program');
            $table->date('graduation_date');
            $table->char('nim', 10)->unique();
            $table->string('full_name');
            $table->string('phone', 20)->nullable();
            $table->string('email', 60)->nullable();
            $table->date('start_work_date')->nullable();
            $table->date('start_work_now_date')->nullable();
            $table->string('study_start_year', 4)->nullable()->comment('tahun awal kuliah/angkatan');
            $table->string('waiting_time', 10)->nullable();
            $table->foreignIdFor(Company::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Profession::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Superior::class)->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
