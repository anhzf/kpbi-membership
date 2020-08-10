<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class Media extends Model
{
    protected $table = 'media';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Default public path.
     *
     * @var string
     */
    const publicPathPrefix = 'media/';

    /**
     * File upload max size.
     *
     * @var int
     */
    const maxFileSize = 1024 * 2;


    public function owner()
    {
        return $this->belongsTo(\App\User::class, 'owner_id');
    }

    public function getpathAttribute()
    {
        return 'uploaded/' . $this->owner_id . '/' . $this->attributes['path'];
    }

    public function getpublicPathAttribute()
    {
        return Media::publicPathPrefix . $this->path;
    }

    /**
     * Store uploaded file and save to database
     *
     * @param \App\User                        $user the media owner
     * @param \Illuminate\Http\UploadedFile    $file
     * @param array                            $options
     * @return \App\Media
     */
    public static function store(User $user, UploadedFile $file, $options = [])
    {
        $availableOptions = [
            'prefix' => '',
            'alt' => null
        ];
        $options = $options + $availableOptions;

        if (!$file->isValid())
            throw new UploadException();

        $path = $file->store("uploaded/{$user->getKey()}/{$options['prefix']}", 'public');

        $recordUploaded = new Media([
            'owner_id' => $user->getKey(),
            'path' => $options['prefix'] . '/' . basename($path),
            'alt' => $options['alt']
        ]);

        $recordUploaded->save();

        return $recordUploaded;
    }
}
