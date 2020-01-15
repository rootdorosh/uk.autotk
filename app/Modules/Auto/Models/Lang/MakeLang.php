<?php 

declare( strict_types = 1 );

namespace App\Modules\Auto\Models\Lang;

use App\Base\Eloquent\BaseModelLang;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Modules\Auto\Models\Make;

class MakeLang extends BaseModelLang
{
    /**
     * table name.
     *
     * @var  string
     */
    protected $table = 'auto_make_lang';

    /**
     * Owner field name.
     *
     * @var string
     */
    public $ownerField = 'make_id';
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'is_translated',
        'title',
    ];
    
    /*
     * @return BelongsTo
     */
    public function make() : BelongsTo
    {
        return $this->belongsTo(Make::class);
    }
    
}
