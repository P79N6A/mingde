<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberOrder extends Model
{
    //
    protected $table = 'app_member_order';
    protected $primaryKey = 'id';
    public $timestamps = false; //�ر� �Զ�����ʱ��
}
