<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class ClassMemberships extends Migration
{
    public function up()
    {
        Schema::create('class_memberships', function (Blueprint $table) {
            $table->integer('classes_id');
            $table->integer('term_id');
            $table->text('member_id');
            $table->text('role_position');
            $table->text('member_status');
            $table->string('email');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_memberships');
    }
}