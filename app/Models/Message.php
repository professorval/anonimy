<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Laravel\Sanctum\HasApiTokens;
    use Illuminate\Database\Eloquent\Model;

    class Message extends Model {

        use HasApiTokens, HasFactory;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'thread_id',
            'content'
        ];
    }