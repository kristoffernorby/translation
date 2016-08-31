<?php namespace Waavi\Translation\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Updater;
use Illuminate\Database\Eloquent\SoftDeletes;

class Translation extends Model
{
  const DELETED_AT = 'destroyed_at';
  public $timestamps = true;
  use SoftDeletes;
  use Updater;

    /**
     *  Table name in the database.
     *  @var string
     */
    protected $table = 'ubsuite.translation';

    /**
     *  List of variables that can be mass assigned
     *  @var array
     */
    protected $fillable = ['locale', 'namespace', 'group', 'item', 'text', 'unstable','missing','updated_at','updated_by'];

    /**
     *  Each translation belongs to a language.
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'locale', 'iso2');
    }

    /**
     *  Returns the full translation code for an entry: namespace.group.item
     *  @return string
     */
    public function getCodeAttribute()
    {
        return $this->namespace === '*' ? "{$this->group}.{$this->item}" : "{$this->namespace}::{$this->group}.{$this->item}";
    }

    /**
     *  Flag this entry as Reviewed
     *  @return void
     */
    public function flagAsReviewed()
    {
        $this->unstable = 0;
    }
    /**
     *  Flag this entry as Not Reviewed
     *  @return void
     */
    public function flagAsNotReviewed()
    {
        $this->unstable = 1;
    }

    /**
     *  Set the translation to the locked state
     *  @return void
     */
    public function lock()
    {
        $this->locked = 1;
    }

    /**
     *  Check if the translation is locked
     *  @return boolean
     */
    public function isLocked()
    {
        return (boolean) $this->locked;
    }
    /**
     *  Check if the translation is missing 
     *  @return boolean
     */
    public function isMissing()
    {
        return (boolean) $this->missing;
    }
}
