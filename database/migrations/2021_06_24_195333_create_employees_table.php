<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id()->comment("Employee Identifier");
            $table->bigInteger('area_id')->nullable()->unsigned()->comment("Area of the company to which the employee belongs. Field type 'Select'. Required");
            $table->bigInteger('newsletter')->nullable()->unsigned()->comment("1 for receive newsletter. 0 for don't receive newsletter. Field type 'Checkbox'. Required")->default(0);
            $table->string('name')->comment("Full name of the employee. Text type field. Only letters with or without tilde and spaces are allowed. Special characters and numbers are not allowed. Required");
            $table->string('email')->comment("Employee's e-mail. Field of type Text|Email. Only allows one mail structure. Required");
            $table->char('sex', 1)->comment("Radio Button type field. M for Male. F for Female. Required");
            $table->text('description')->comment("The employee's experience is described. Field of type textarea. Required");
            $table->timestamps();

            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
