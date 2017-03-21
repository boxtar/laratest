<?php

namespace App\Http\Controllers;

use Image;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Contracts\StorageManager;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    /**
     * @var StorageManager
     */
    protected $storage;

    /**
     * MediaController constructor.
     * @param StorageManager $storage
     */
    public function __construct(StorageManager $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Sends raw image data back to requester with appropriate headers set
     *
     * @param \App\User | \App\Group $target
     * @param $image_name
     * @return mixed
     */
    public function getImage($target, $image_name)
    {
        return Image::make( $target->getThumbnail($this->storage, $image_name) )->response();
    }

    /**
     * Stores an image to the targets storage area
     *
     * @param $target
     * @param Request $request
     */
    public function storeImage($target, Request $request)
    {
        // Authorize the ability to add an image
        $this->authorize('manage_media', $target);

        // Validate Request
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,png,bmp'
        ]);

        // Add image to targets storage path
        $target->addImage($request->file('image'));
    }

    /**
     * Destroy an image
     *
     * @param $target
     * @param $image_name
     * @param StorageManager $storage
     * @return string
     */
    public function destroyImage($target, $image_name, StorageManager $storage)
    {
        $this->authorize('manage_media', $target);

        $storage->changeDirectory( $target->imagePath() )->removeFile($image_name);

        flash()->info('', 'Image Removed');

        return redirect()->route('users.show', [$target->profile_link]);
    }
}
