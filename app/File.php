<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

use Image;
use Log;

class File extends Model
{
    protected $folder = '';

    protected $fillable = [
        'user_id',
        'path',
        'original_basename'
    ];

    protected $thumbSizes = [
        1600,
        800,
        400,
        200
    ];

    public function get($size = null)
    {
        return Storage::get($this->pathForSize($size));
    }

    public function name()
    {
        return pathinfo($this->path, PATHINFO_FILENAME);
    }

    public function basename()
    {
        return pathinfo($this->path, PATHINFO_BASENAME);
    }

    public function dirname()
    {
        return pathinfo($this->path, PATHINFO_DIRNAME);
    }

    public function extension()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    public function mimeType()
    {
        return Storage::mimeType($this->path);
    }

    public function streamResponse($size)
    {
        return response()->stream(function () use ($size) {
            echo $this->get($size);
        }, 200, ['content-type' => $this->mimeType()]);
    }

    public function pathForSize($size = null)
    {
        $suffix = $size === null ? '' : '_w'.$size;

        return $this->dirname().'/'.$this->name().$suffix.'.'.$this->extension();
    }

    public function generateThumbs()
    {
        foreach ($this->thumbSizes as $size) {
            $thumb = Image::make($this->get())
            ->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->stream();

            Storage::put($this->pathForSize($size), $thumb);
        }
    }
}
