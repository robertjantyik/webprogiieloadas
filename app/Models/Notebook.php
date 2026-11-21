<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Notebook extends Model
{
    protected $fillable = ['manufacturer','model','screen_size','memory_mb','disk_gb','graphics','price','processor_id','operating_system_id'];
    public function processor() { return $this->belongsTo(Processor::class); }
    public function operatingSystem() { return $this->belongsTo(OperatingSystem::class); }
}
