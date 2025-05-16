<?php

use App\Models\Company;
use App\Models\Profession;
use App\Models\Question;
use App\Models\Questionnaire;
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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->enum('filler_type', ['alumni', 'superior']);
            $table->bigInteger('filler_id');
            $table->bigInteger('alumni_id')->nullable(); //case if type superior
            $table->foreignIdFor(Questionnaire::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Question::class)->constrained()->cascadeOnDelete();
            $table->text('answer');
            $table->boolean('is_assessment')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
