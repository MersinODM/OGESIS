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
        Schema::create('ogs_provinces', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->nullable();
            $table->string('name', 1000);
            $table->timestamps();
        });
        //İlçeler
        Schema::create('ogs_districts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('province_id');
            $table->string('code', 50)->nullable();
            $table->string('name', 1000);
            $table->timestamps();

            $table->foreign("province_id")
                ->references("id")
                ->on("ogs_provinces");
        });

        Schema::create('ogs_branches', function (Blueprint $table) {
            $table->id()->startingValue(100);
            $table->string('code', 50)->nullable();
            $table->string('name', 1000);
            $table->string('levels', 100)
                ->comment("Dersin okutulduğu sınıf virgülle ayrılmış seviyeleri. Örn: 9,10,11 ");
            $table->timestamps();
            $table->softDeletes();
        });
        //Kurumlar
        Schema::create('ogs_institutions', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedInteger('type')->nullable(); //10: İl MEM,11: İlçe MEM, 12:Okul
            $table->string('name', 500);
            $table->string('phone', 20)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps();

            $table->primary("id");

            $table->foreign("district_id")
                ->references("id")
                ->on("ogs_districts");
        });

        Schema::create('ogs_teams', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->unsignedInteger('institution_id');
            $table->string("name");
            $table->timestamps();

            $table->foreign('institution_id')
                ->references('id')
                ->on('ogs_institutions');
        });

        Schema::create('ogs_notifications', function (Blueprint $table) {
            $table->id()->startingValue(10000);
            $table->unsignedInteger('notifiable_id');
            $table->unsignedInteger('notifiable_type');
            $table->string("title", 500)->nullable();
            $table->string("content", 5000)->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        Schema::create('ogs_facilities', function (Blueprint $table) {
            $table->id()->startingValue(100);
            $table->string("name", 500)->nullable();
            $table->string("description", 5000)->nullable();
            $table->timestamps();
        });

        Schema::create('ogs_institution_facilities', function (Blueprint $table) {
            $table->unsignedInteger('institution_id');
            $table->unsignedBigInteger('facility_id');
            $table->unsignedInteger('count')->nullable();
            $table->timestamps();

            $table->primary(['institution_id', 'facility_id']);

            $table->foreign('institution_id')
                ->references('id')
                ->on('ogs_institutions');

            $table->foreign('facility_id')
                ->references('id')
                ->on('ogs_facilities');
        });

        Schema::create('ogs_dev_plans', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->string("name", 500)->nullable();
            $table->string("code", 50)->nullable();
            $table->date("start_date")->nullable();
            $table->date("end_date")->nullable();
            $table->boolean("is_open")->default(true);
            $table->unsignedBigInteger("creator_id")->nullable();
            $table->string("description", 5000)->nullable();
            $table->timestamps();
        });

        Schema::create('ogs_institution_plans', function (Blueprint $table) {
            $table->unsignedInteger('institution_id');
            $table->unsignedBigInteger('plan_id');
            $table->timestamps();
            $table->primary(['institution_id', 'plan_id']);
            $table->foreign('institution_id')
                ->references('id')
                ->on('ogs_institutions');

            $table->foreign('plan_id')
                ->references('id')
                ->on('ogs_dev_plans');
        });

        Schema::create('ogs_report_requests', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->unsignedBigInteger('plan_id');
            $table->unsignedInteger('institution_id');
            $table->unsignedBigInteger('creator_id');
            $table->string('code',10);
            $table->string('description', 5000);
            $table->json('report')->nullable(); // Bu önemli ileride raporları bunun içine json olarak koyucaz
            $table->binary('file')->nullable();
            $table->string('file_name', 300)->nullable();
            $table->timestamps();

            $table->foreign('institution_id')
                ->references('id')
                ->on('ogs_institutions');

            $table->foreign('plan_id')
                ->references('id')
                ->on('ogs_dev_plans');
        });

//        Schema::create('ogs_reports', function (Blueprint $table) {
//            $table->id()->startingValue(10000);
//            $table->unsignedBigInteger('request_id');
////            $table->unsignedInteger('institution_id');
////            $table->unsignedBigInteger('plan_id');
//            $table->string('name')->nullable();
//            $table->json('report')->nullable(); // Bu önemli ileride raporları bunun içine json olarak koyucaz
//            $table->binary('file')->nullable();
//            $table->timestamps();
//
//            $table->foreign('request_id')
//                ->references('id')
//                ->on('ogs_report_requests');
//        });

//        Schema::create('ogs_attachments', function (Blueprint $table) {
//            $table->id()->startingValue(10000);
//            // Polimorfik ilişki kullanıyoruz
//            $table->unsignedBigInteger('attachable_id');
//            $table->string('attachable_type');
//            $table->tinyInteger('type')->nullable();
//            $table->string('name')->nullable();
//            $table->binary('file')->nullable();
//            $table->timestamps();
//        });

        Schema::create('ogs_institution_infos', function (Blueprint $table) {
            $table->id()->startingValue(1000);;
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
            $table->id()->startingValue(1000);;
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('code', 10)->nullable();
            $table->string('name', 1000);
            $table->string('description', 5000)->nullable();
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('ogs_activity_themes');
        });

        Schema::create('ogs_activities', function (Blueprint $table) {
            $table->id()->startingValue(10000);;
            $table->unsignedBigInteger("plan_id");
            $table->unsignedInteger("institution_id");
            $table->unsignedBigInteger("theme_id");
            $table->unsignedBigInteger("team_id")->nullable();
            $table->unsignedBigInteger("type_id")->nullable();
            $table->string("title", 500);
            $table->string("description", 5000);
            $table->date("planned_start_date");
            $table->date("start_date")->nullable();
            $table->date("planned_end_date");
            $table->date("end_date")->nullable();
            $table->unsignedSmallInteger('status')
                ->nullable()
                ->comment('0: Planlanıyor, 1:Başlandı, 2:Tamamlandı, 3:İptal Edildi ');
            $table->string('cancel_reason', 1000)->nullable();
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

            $table->foreign('institution_id')
                ->references('id')
                ->on('ogs_institutions');

            $table->foreign('team_id')
                ->references('id')
                ->on('ogs_teams');
        });

        Schema::create('ogs_partners', function (Blueprint $table) {
            $table->id()->startingValue(100);
            $table->string('code')->nullable();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('ogs_activity_partners', function (Blueprint $table) {
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('partner_id');
            $table->timestamps();
            $table->primary(['activity_id', 'partner_id']);

            $table->foreign('activity_id')
                ->references('id')
                ->on('ogs_activities');

            $table->foreign('partner_id')
                ->references('id')
                ->on('ogs_partners');
        });

        Schema::create('ogs_activity_comments', function (Blueprint $table) {
            $table->id()->startingValue(10000);
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



        Schema::create('ogs_teachers', function (Blueprint $table) {
            $table->id()->startingValue(10000);;
            $table->unsignedBigInteger("branch_id");
            $table->unsignedInteger("institution_id");
            $table->string("first_name", 100);
            $table->string("last_name", 100);
            $table->string("phone", 15)->nullable();
            $table->string("email", 50)->nullable();
            $table->timestamps();


            $table->foreign('branch_id')
                ->references('id')
                ->on('ogs_branches');

            $table->foreign('institution_id')
                ->references('id')
                ->on('ogs_institutions');
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
        Schema::dropIfExists('ogs_activity_comments');
        Schema::dropIfExists('ogs_activity_partners');
        Schema::dropIfExists('ogs_partners');
        Schema::dropIfExists('ogs_activities');
        Schema::dropIfExists('ogs_activity_types');
        Schema::dropIfExists('ogs_activity_themes');
        Schema::dropIfExists('ogs_institution_infos');
        Schema::dropIfExists('ogs_report_requests');
        Schema::dropIfExists('ogs_institution_plans');
        Schema::dropIfExists('ogs_dev_plans');
        Schema::dropIfExists('ogs_institution_facilities');
        Schema::dropIfExists('ogs_facilities');
        Schema::dropIfExists('ogs_notifications');
        Schema::dropIfExists('ogs_teams');
        Schema::dropIfExists('ogs_institutions');
        Schema::dropIfExists('ogs_branches');
        Schema::dropIfExists('ogs_districts');
        Schema::dropIfExists('ogs_provinces');
    }
}
