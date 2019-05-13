<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberChange extends Model
{
    //
    protected $table = 'app_member_change';
    protected $primaryKey = 'id';
    public $timestamps = false; //�ر� �Զ�����ʱ��

    protected $fillable = [

    ];

    const UPDATED_AT='update_at';
    const CREATED_AT = 'create_at';

}
