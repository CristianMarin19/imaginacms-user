<?php

namespace Modules\Iuser\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Modules\Iuser\Repositories\UserRepository;
use Imagina\Icore\Repositories\Eloquent\EloquentCoreRepository;

class EloquentUserRepository extends EloquentCoreRepository implements UserRepository
{
    /**
     * Filter names to replace
     * @var array
     */
    protected array $replaceFilters = [];

    /**
     * Relation names to replace
     * @var array
     */
    protected array $replaceSyncModelRelations = [];

    /**
     * Attribute to define default relations
     * all apply to index and show
     * index apply in the getItemsBy
     * show apply in the getItem
     * @var array
     */
    protected array $with = [/*all => [] ,index => [],show => []*/];

    /**
     * @param Builder $query
     * @param object $filter
     * @param object $params
     * @return Builder
     */
    public function filterQuery(Builder $query, object $filter, object $params): Builder
    {

        /**
         * Note: Add filter name to replaceFilters attribute before replace it
         *
         * Example filter Query
         * if (isset($filter->status)) $query->where('status', $filter->status);
         *
         */

        //filter by Role ID
        if (isset($filter->roleId) && ((int)$filter->roleId) != 0) {
            $query->whereIn('id', function ($query) use ($filter) {
                $query->select('user_id')->from('iuser__role_user')->where('role_id', $filter->roleId);
            });
        }

        //filter by Role Slug
        if (isset($filter->roleSystemName)) {
            $query->whereIn('id', function ($query) use ($filter) {
                $query->select('user_id')->from('iuser__role_user')->where('role_id', function ($subQuery) use ($filter) {
                    $subQuery->select('id')->from('iuser__roles')->where('system_name', $filter->roleSystemName);
                });
            });
        }

        //filter by Roles
        if (isset($filter->roles) && count($filter->roles)) {
            $query->whereIn('id', function ($query) use ($filter) {
                $query->select('user_id')->from('iuser__role_user')->whereIn('role_id', $filter->roles);
            });
        }

        //Response
        return $query;
    }

    /**
     * @param Model $model
     * @param array $data
     * @return Model
     */
    public function syncModelRelations(Model $model, array $data): Model
    {
        //Get model relations data from model attributes
        //$modelRelationsData = ($model->modelRelations ?? []);

        /**
         * Note: Add relation name to replaceSyncModelRelations attribute before replace it
         *
         * Example to sync relations
         * if (array_key_exists(<relationName>, $data)){
         *    $model->setRelation(<relationName>, $model-><relationName>()->sync($data[<relationName>]));
         * }
         *
         */

        //Response
        return $model;
    }
}
