<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
class Data extends Model
{
    use HasTrixRichText;

    protected $table='data';

    protected $fillable=[
    	'title','id_taxonomy','label','id_post_type','id_user','no_dokumen','perihal','max_pages',
        'path_file','path_file_pages','data_date','data-trixFields','attachment-data-trixFields'
    ];	


    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($data) {
            $data->trixRichText->each->delete();
            $data->trixAttachments->each->purge();
        });
    }

   

}
