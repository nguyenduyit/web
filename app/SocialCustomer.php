<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialCustomer extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
          'provider_user_id',  'provider',  'user'
    ];
 
    protected $primaryKey = 'user_id';
 	protected $table = 'tbl_social_customer';
     public function customerLogin(){
        return $this->belongsTo('App\Customer', 'user');
    }

}
