<?php namespace App\Repositories\Criteria\User;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

class UsersByAdminType extends Criteria {


    /**
     * @param $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply( $model, Repository $repository )
    {
        $model = $model->whereNotIn('id', function($query){
            $query->select('user_id')
                ->from('ec_customer');
        });
        return $model;
    }

}
