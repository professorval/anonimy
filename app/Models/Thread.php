<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Laravel\Sanctum\HasApiTokens;
    use Illuminate\Database\Eloquent\Model;

    class Thread extends Model {

        use HasApiTokens, HasFactory;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'title',
            'user_id',
            'slug'
        ];
    }