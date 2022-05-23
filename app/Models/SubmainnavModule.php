<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmainnavModule extends Model
{
    use HasFactory;

    protected $table = 'submainnavmodule';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'sub_module_id';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sub_module_name',
        'sub_module_icon',
        'is_visible',
        'sort_order',
        'company_id',
        'uid'
    ];
}
