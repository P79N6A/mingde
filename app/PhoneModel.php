<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneModel extends Model
{
    //
    protected $table = 'app_model';
    protected $primaryKey = 'id';
//    public $timestamps = false; //�ر� �Զ�����ʱ��
    const UPDATED_AT='update_at';
    const CREATED_AT = 'create_at';

}
