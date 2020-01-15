<?php 

declare( strict_types = 1 );

namespace App\Modules\Auto\Models\Lang;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Base\Eloquent\BaseModelLang;
use App\Modules\Auto\Models\Model;

class ModelLang extends BaseModelLang
{
    /**
     * table name.
     *
     * @var  string
     */
    protected $table = 'auto_model_lang';
    
    /**
     * Owner field name.
     *
     * @var string
     */
    public $ownerField = 'model_id';

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
    public function model() : BelongsTo
    {
        return $this->belongsTo(Model::class);
    }
    
}
