<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Models\Lang;

use Illuminate\Database\Eloquent\Model;

class DomainLang extends Model
{
    /**
     * primary key.
     *
     * @var  string
     */
    protected $primaryKey = 'translation_id';
       
    /**
     * table name.
     *
     * @var  string
     */
    protected $table = 'core_domains_lang';

    /**
     * @var  bool
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'title', 
    ];
}
