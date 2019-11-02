<?php

use App\Models\User;
use Envant\Friendships\Friendships;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $userClass = Friendships::getAuthModelName();
        $userModel = new $userClass();

        Schema::create(config('friendships.table'), function (Blueprint $table) use ($userModel) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sender_id');
            $table->foreign('sender_id')
                ->references($userModel->getKeyName())
                ->on($userModel->getTable())
                ->onDelete('cascade');

            $table->unsignedBigInteger('recipient_id');
            $table->foreign('recipient_id')
                ->references($userModel->getKeyName())
                ->on($userModel->getTable())
                ->onDelete('cascade');

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
        Schema::dropIfExists(config('friendships.table'));
    }
}
