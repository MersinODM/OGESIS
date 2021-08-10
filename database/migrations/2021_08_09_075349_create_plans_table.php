<?php /** @noinspection ALL */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('ogs_facilities', function (Blueprint $table) {
                $table->id();
                $table->string("name", 500)->nullable();
                $table->string("description", 5000)->nullable();
                $table->timestamps();

//            $table->foreign('institution_id')
//                ->references('id')
//                ->on('institutions');
            });

            Schema::create('ogs_institution_facilities', function (Blueprint $table) {
                $table->unsignedInteger('institution_id');
                $table->unsignedBigInteger('facility_id');
                $table->unsignedInteger('count')->nullable();
                $table->timestamps();

                $table->primary(['institution_id', 'facility_id']);


//            $table->foreign('institution_id')
//                ->references('id')
//                ->on('ogs_teachers');

                $table->foreign('facility_id')
                    ->references('id')
                    ->on('ogs_facilities');
            });


            Schema::create('ogs_dev_plans', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger("institution_id");
                $table->string("description", 5000)->nullable();
                $table->string('report_name')->nullable();
                $table->binary('report_file')->nullable();
                $table->date("start_date")->nullable();
                $table->date("end_date")->nullable();
                $table->boolean("is_open")->default(true);
                $table->timestamps();

//            $table->foreign('institution_id')
//                ->references('id')
//                ->on('institutions');
            });

            Schema::create('ogs_institution_infos', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("plan_id");
                $table->unsignedInteger("student_count")->nullable();
                $table->unsignedInteger("teacher_count")->nullable();
                $table->unsignedInteger("postgraduate_count")->nullable();
                $table->unsignedInteger("doctorate_count")->nullable();
                $table->string("description", 5000)->nullable();
                $table->timestamps();

                $table->foreign('plan_id')
                    ->references('id')
                    ->on('ogs_dev_plans');
            });

            Schema::create('ogs_activity_types', function (Blueprint $table) {
                $table->id();
                $table->string("name", 500);
                $table->timestamps();
            });

            Schema::create('ogs_activity_themes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->string('code', 10)->nullable();
                $table->string('name', 1000);
                $table->string('description', 5000)->nullable();

                $table->foreign('parent_id')
                    ->references('id')
                    ->on('ogs_activity_themes');
            });

            Schema::create('ogs_activities', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("plan_id");
                $table->unsignedBigInteger("type_id");
                $table->unsignedBigInteger("theme_id");
                $table->string("title", 500);
                $table->string("description", 5000);
                $table->tinyInteger("interlocutor")->comment('Öğrenci:0, Öğretmen:1, Veli:2'); //'aktivetinin muhatapları'
                $table->date("start_date")->nullable();
                $table->date("end_date")->nullable();
                $table->unsignedSmallInteger('status')->nullable();
                $table->timestamps();

                $table->foreign('theme_id')
                    ->references('id')
                    ->on('ogs_activity_themes');

                $table->foreign('type_id')
                    ->references('id')
                    ->on('ogs_activity_types');

                $table->foreign('plan_id')
                    ->references('id')
                    ->on('ogs_dev_plans');

            });

            Schema::create('ogs_activity_comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("activity_id");
                $table->unsignedBigInteger("creator_id");
                $table->string("title", 500);
                $table->string("description", 5000);
                $table->unsignedSmallInteger('comment_type')->nullable();
                $table->timestamps();

                $table->foreign('activity_id')
                    ->references('id')
                    ->on('ogs_activities');
            });

            Schema::create('ogs_teams', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('plan_id');
                $table->string("team_name");
                $table->timestamps();

                $table->foreign('plan_id')
                    ->references('id')
                    ->on('ogs_dev_plans');
            });

            Schema::create('ogs_teachers', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("branch_id");
                $table->unsignedInteger("institution_id");
                $table->string("first_name", 100);
                $table->string("last_name", 100);
                $table->string("phone", 15)->nullable();
                $table->string("email", 15)->nullable();
                $table->timestamps();


//            $table->foreign('branch_id')
//                ->references('id')
//                ->on('lessons');
//
//            $table->foreign('institution_id')
//                ->references('id')
//                ->on('institutions');
            });

            Schema::create('ogs_activity_members', function (Blueprint $table) {
                $table->unsignedBigInteger('teacher_id');
                $table->unsignedBigInteger('activity_id');
                $table->timestamps();
                $table->primary(['teacher_id', 'activity_id']);

                $table->foreign('teacher_id')
                    ->references('id')
                    ->on('ogs_teachers');

                $table->foreign('activity_id')
                    ->references('id')
                    ->on('ogs_activities');
            });

            Schema::create('ogs_team_teachers', function (Blueprint $table) {
                $table->unsignedBigInteger('teacher_id');
                $table->unsignedBigInteger('team_id');
                $table->timestamps();
                $table->primary(['teacher_id', 'team_id']);


                $table->foreign('teacher_id')
                    ->references('id')
                    ->on('ogs_teachers');

                $table->foreign('team_id')
                    ->references('id')
                    ->on('ogs_teams');
            });
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ogs_team_teachers');
        Schema::dropIfExists('ogs_activity_members');
        Schema::dropIfExists('ogs_teachers');
        Schema::dropIfExists('ogs_teams');
        Schema::dropIfExists('ogs_activity_comments');
        Schema::dropIfExists('ogs_activities');
        Schema::dropIfExists('ogs_activity_types');
        Schema::dropIfExists('ogs_activity_themes');
        Schema::dropIfExists('ogs_institution_infos');
        Schema::dropIfExists('ogs_dev_plans');
        Schema::dropIfExists('ogs_institution_facilities');
        Schema::dropIfExists('ogs_facilities');
    }
}
