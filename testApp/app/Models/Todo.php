<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

        /**
    * @var array
    */
    protected $fillable = ['title', 'content']; // 追記

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at']; // 追記
}
