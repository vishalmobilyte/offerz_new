<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ActivityLogsTable extends Table
{
	public function initialize(array $config)
    {
        $this->belongsTo('Users');
    }


}
?>