<?php

namespace VnCoder\Models;

use Illuminate\Database\Eloquent\Model;
use VnCoder\Helper\FormData;

class VnModel extends Model
{
    use VnCoder;
    public const CREATED_AT = 'created';
    public const UPDATED_AT = 'updated';

    protected $primaryKey = 'id';
    protected $dateFormat = 'U';
    protected $rules = [];
    protected $crudKey = [];
    protected $searchFields = [];

    public static function loadData($id = 0)
    {
        $info = self::where('id', $id)->first();
        if (!$info) {
            $info = newObject();
            foreach (with(new static)->fillable as $item) {
                $info->$item = '';
            }
        } else {
            if ($info->status < 0) {
                return false;
            }
        }
        return $info;
    }

    public static function getInfo($id = 0)
    {
        return self::where('id', $id)->first();
    }

    public static function getIds($ids = [])
    {
        return self::whereIn('id', $ids)->where('status', '>', 0)->get();
    }

    public static function getRules()
    {
        return with(new static())->rules;
    }

    public static function getQueryField()
    {
        return with(new static())->crudKey;
    }

    public static function getData($orderBy = 'id', $sortBy = 'desc', $limit = 20)
    {
        if (!in_array($orderBy, with(new static())->crudKey, true)) {
            $orderBy = 'id';
        }
        $sortBy = $sortBy === 'asc' ? 'asc' : 'desc';

        $query = self::active();
        $_query = getParam('_query', '');
        if ($_query) {
            $query->search($_query, with(new static)->searchFields);
        }
        return $query->orderBy($orderBy, $sortBy)->paginate($limit);
    }

    public function scopeSearch($query, $search, $column = '')
    {
        if (is_array($column)) {
            $count = 0;
            foreach ($column as $item) {
                if ($count === 0) {
                    $query->where($item, 'LIKE', '%'.$search.'%');
                } else {
                    $query->orWhere($item, 'LIKE', '%'.$search.'%');
                }
                $count++;
            }
        } else {
            $query->where($column, 'LIKE', '%'.$search.'%');
        }

        return $query;
    }

    public function scopeActive($query)
    {
        return $query->where('status', '>', 0);
    }

    protected function getFormOption(): array
    {
        return [];
    }

    public static function getFormData($id = 0)
    {
        return self::where('id', $id)->first();
    }

    public static function submit($data = null)
    {
        if (!$data) {
            $data = request()->all();
        }

        $id = $data['id'] ?? 0;
        $fillable = with(new static())->fillable;
        $updateData = [];
        foreach ($fillable as $k) {
            if ($k == 'user_id') {
                if ($id == 0) {
                    $updateData['user_id'] = VnUser::getUid();
                }
            } else {
                if (isset($data[$k])) {
                    $updateData[$k] = trim($data[$k]);
                }
            }
        }
        // Remove ID
        unset($updateData['id']);
        if ($id > 0) {
            $updateData['updated'] = TIME_NOW;
            flash_message('Bản ghi đã được cập nhật');
            self::where('id', $id)->update($updateData);
        } else {
            $updateData['created'] = TIME_NOW;
            flash_message('Bản ghi đã được lưu lại');
            $id = self::insertGetId($updateData);
        }
        return $id;
    }

    // ACTIVE - REMOVE ID
    public static function hiddenId($id = 0, $message = null)
    {
        if ($id) {
            $action = self::whereId($id)->update(['status' => -1]);
            if (!$message) {
                $message = 'Bản ghi có id ' .$id. ' đã được xóa thành công!';
            }
            flash_message($message);
            return $action;
        }
        return false;
    }

    public static function showId($id = 0, $message = null)
    {
        if ($id) {
            $action = self::whereId($id)->update(['status' => 1]);
            if (!$message) {
                $message = 'Bản ghi có id ' .$id. ' đã được khôi phục';
            }
            flash_message($message);
            return $action;
        }
        return false;
    }
}
