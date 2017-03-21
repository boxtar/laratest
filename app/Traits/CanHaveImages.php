<?php

namespace App\Traits;

use Image;
use App\Contracts\StorageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;


trait CanHaveImages{

    public function addImage(UploadedFile $image)
    {
        // Create unique name for file
        $name = sha1( time() . $image->getClientOriginalName() ) . '.' . $image->getClientOriginalExtension();

        // Use Intervention to make and then save image
        $img = Image::make($image)->save( storage_path( 'app/' . $this->imagePath() . '/' . $name ) );

        // Use Intervention to make thumbnail and save
        $img->fit(250)->save(storage_path('app/' . $this->imagePath() . '/' . 'tn-' . $name));
    }

    /**
     * Returns an array of image names - by default, it's thumbnails that are returned
     *
     * @param StorageManager $storage
     * @param string $thumbnails
     * @return array|bool
     */
    public function getImages(StorageManager $storage, $thumbnails = 'true')
    {
        if($thumbnails) { return $this->getThumbnails($storage); }

        else{
            // Capture all full size images
            return true;
        }
    }


    /**
     * Returns the requested image. Returns the thumbnail by default
     *
     * @param StorageManager $storage
     * @param $filename
     * @param string $thumbnail
     * @return bool
     */
    public function getImage(StorageManager $storage, $filename, $thumbnail = 'true')
    {
        if($thumbnail) { return $this->getThumbnail($storage, $filename); }

        else {
            // Capture full size image
            return true;
        }
    }

    /**
     * Returns an array of thumbnail image names
     *
     * @param StorageManager $storage
     * @return array
     */
    public function getThumbnails(StorageManager $storage)
    {
        $all_files = $storage->cd($this->imagePath())->getFiles();

        $images = [];

        foreach( $all_files as $image ){
            $img_name = substr($image, strrpos($image, '/') + 1);

            if( starts_with( $img_name, config('boxtar.thumbnailPrefix') ) )
                $images[] = $img_name;
        }

        return $images;
    }

    public function getThumbnail(StorageManager $storage, $filename)
    {
        if(! starts_with($filename, config('boxtar.thumbnailPrefix') )) $filename = config('boxtar.thumbnailPrefix') . $filename;

        try{
            $thumb = $storage->getFile($this->imagePath().'/'.$filename);
        }
        catch(\Exception $e){
            $thumb = $storage->getFile($this->imagePath().'/'.config('boxtar.fileNotFound'));
        }
        return $thumb;
    }

}


