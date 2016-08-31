<?php namespace Waavi\Translation\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{

  const DELETED_AT = 'destroyed_at';
    /**
     *  Table name in the database.
     *  @var string
     */
    protected $table = 'MasterData.language';

    /**
     *  List of variables that cannot be mass assigned
     *  @var array
     */
    protected $fillable = [
        'iso2',
        'iso3',
        'name',
        'country_id',
        'created_by',
        'updated_by'
    ];

    /**
     *  Each language may have several translations.
     */
    public function translations()
    {
        return $this->hasMany(Translation::class, 'locale', 'iso2');
    }

    /**
     *  Returns the name of this language in the current selected language.
     *
     *  @return string
     */
    public function getLanguageCodeAttribute()
    {
        return "language.{$this->locale}";
    }


    public function country(){
        return $this->belongsTo('App\Models\Country','country_id');
    } 

}
