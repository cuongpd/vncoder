<?php

namespace VnCoder\Models;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManager;

class VnMedia extends Model
{
    public const CREATED_AT = 'created';
    public const UPDATED_AT = 'updated';
    protected $dateFormat = 'U';
    protected $table = '__media';
    protected $fillable = ['user_id', 'name', 'title', 'alt_text', 'type', 'path', 'size', 'status'];
    protected $guarded = [];

    protected $allowed_file_types = ['jpg', 'png', 'gif', 'jpeg'];

    public function getThumbnailAttribute()
    {
        if ($this->type == 'gif') {
            return url($this->photo);
        }
        return url('uploads/thumb/' . $this->path);
    }

    public function getPhotoAttribute()
    {
        return 'uploads/photo/' . $this->path;
    }

    public function getMediaInfoAttribute()
    {
        return [
            'ID'            => $this->id,
            'name'          => $this->name,
            'size'          => $this->formatBytes(),
            'mime_type'     => $this->type,
            'photo'         => $this->photo,
            'thumbnail'     => $this->thumbnail,
            'time'          => $this->created->format('d/m/Y'),
        ];
    }

    public function formatBytes($precision = 2)
    {
        $size = $this->size;
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }

    public function getReadableSizeAttribute()
    {
        return $this->formatBytes();
    }

    public static function removeMedia($user_id = 0)
    {
        $media_ids = getParam('media_ids', '');
        if (! empty($media_ids)) {
            $media_ids = array_filter(explode(',', $media_ids));
            if (is_array($media_ids)) {
                self::whereIn('id', $media_ids)->update(['status' => -1]);
            }
        }
        return ['success' => true, 'msg' => 'Media đã bị xoá'];
    }

    public static function getMedia($user_id, $is_root = false, $limit = 20)
    {
        $query = self::where('status', '>', 0);
        if (!$is_root) {
            $query->where('user_id', $user_id);
        }
        $search = getParam('_query', '');
        if ($search) {
            $query->where("name", 'like', "%{$search}%");
        }

        return $query->orderBy('id', 'desc')->paginate($limit);
    }

    public static function loadMedia($limit = 20)
    {
        $userInfo = VnUser::getUser();
        if ($userInfo) {
            $user_id = $userInfo['id'];
            $is_root = $userInfo['role_id'] == 1;
            $query = self::where('status', '>', 0);
            if (!$is_root) {
                $query->where('user_id', $user_id);
            }
            $search = getParam('_query', '');
            if ($search) {
                $query->where("name", 'like', "%{$search}%");
            }
            return $query->orderBy('id', 'desc')->paginate($limit);
        }
        return false;
    }

    public static function upload($user_id = 0)
    {
        if (request()->hasFile('files')) {
            $files = request()->file('files');
            try {
                foreach ($files as $file) {
                    $getFilename = $file->getClientOriginalName();
                    $clientExt = $file->getClientOriginalExtension();
                    if (!in_array($clientExt, with(new static())->allowed_file_types)) {
                        return ['success' => false, 'msg' => 'Định dạng ' . $clientExt . ' không được phép upload, chỉ hỗ trợ png, jpg, jpeg và gif'];
                    }
                    $getSize = $file->getSize();
                    if ($getSize > 2500000) {
                        return ['success' => false, 'msg' => 'Dung lượng file ảnh quá lớn!'];
                    }
                    $media_name = safe_text(str_replace('.' . $clientExt, '', $getFilename)) . '.' . $clientExt;

                    $akey = md5($media_name . '-' . time());
                    $media_slug = substr($akey, 0, 2) . '/' . substr($akey, 2, 2) . '/';
                    $upload_dir = PUBLIC_PATH . 'uploads' ;

                    if ($clientExt !== 'gif') {
                        $manager = new ImageManager(['driver' => 'gd']);
                        $media = $manager->make($file);
                        // Thumb
                        $img_save_folder = $upload_dir . '/thumb/' . $media_slug;
                        make_dir($img_save_folder);
                        $img_path = $img_save_folder . $media_name;
                        $media->fit(200, 200)->save($img_path);
                    }
                    // Move File
                    $img_save_folder = $upload_dir . '/photo/' . $media_slug;
                    make_dir($img_save_folder);
                    $file->move($img_save_folder, $media_name);

                    self::updateOrCreate(
                        ['path' => $media_slug . $media_name],
                        ['user_id' => $user_id, 'name' => $getFilename, 'size' => $getSize, 'path' => $media_slug . $media_name, 'type' => $clientExt]
                    );
                }
            } catch (\Exception $e) {
                return ['success' => false, 'msg' => $e->getMessage()];
            }
            return ['success' => true, 'msg' => 'Upload thành công! Tải lại trang nếu bạn chưa thấy ảnh.'];
        }
    }
}
