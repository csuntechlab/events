<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class Events extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bedrock.events', function (Blueprint $table) {
            $table->string('entities_id',255);
//            COMMENT 'E.g., office-hours:2187:103166750',
            $table->integer('term_id');
            $table->integer('pattern_number')->default(1);
            $table->string('type',64)->default('office-hours');
//            E.g.: office-hours, final-exam, class, committee',
            $table->string('label',64)->default('General Office Hours');
            $table->string('description',2048)->nullable()->default(null);
            $table->string('start_time',8)->nullable()->default(null);
            $table->string('end_time',8)->nullable()->default(null);
            $table->string('days',8)->nullable()->default(null);
//            first day of class?
            $table->date('from_date')->nullable()->default(null);
//            last day of class?
            $table->date('to_date')->nullable()->default(null);
            $table->string('location_type',8)->default('physical');
//            COMMENT 'physical or online',
            $table->string('location',64)->nullable()->default(null);
//            COMMENT 'E.g., JD2215',
            $table->boolean('is_byappointment')->default(false);
            $table->boolean('is_walkin')->default(true);
            $table->string('booking_url',2048)->nullable()->default(null);
            $table->string('online_label',8)->nullable()->default(null);
//            COMMENT 'E.g., Zoom',
            $table->string('online_url',255)->nullable()->default(null);
//            COMMENT 'E.g., https://csun.zoom.us/j/5024885325',
//            $table->primary(array('entities_id','term_id','pattern_number','type'));
//
//            $table->index('entities_id');
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
        Schema::dropIfExists('bedrock.events');
    }
}