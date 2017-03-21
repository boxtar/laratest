<?php
namespace App\Services;

use App\Contracts\StorageManager;
use Illuminate\Filesystem\FilesystemManager;

class LaravelStorageManager implements StorageManager{

    /*
     * Instance of the underlying Filesystem implementation
     */
    protected $filesystem;

    /*
     * The disk to access
     */
    protected $disk;

    /*
     * Force operation
     */
    protected $forceOperation = false;

    /*
     * The directory to prepend to operations
     * Useful for doing multiple operations within the same directory
     */
    protected $workingDirectory = '';

    /*
     * Directories to be created
     */
    protected $directories = [];

    /*
     * Files to be copied
     */
    protected $filesToCopy = [];

    /*
     * Files to be moved
     */
    protected $filesToMove = [];


    public function __construct(FilesystemManager $filesystem)
    {
        $this->filesystem = $filesystem;

        $this->disk = config('filesystems.default');
    }


    /**
     * Create the given directory
     *
     * @param $directory
     * @return $this
     */
    public function createDirectory($directory)
    {
        if(is_string($directory)){
            if(! $this->getDisk()->exists($this->pathCreator($directory)) || $this->forceOperation)
                $this->getDisk()->makeDirectory($this->pathCreator($directory), 0755, true);
        }
        else{
            $this->abort('Internal Error');
        }

        return $this;
    }

    /**
     * Create the given list of directories
     *
     * @param $directories
     * @return $this|LaravelStorageManager
     */
    public function createDirectories($directories)
    {
        if(is_string($directories)){
            return $this->createDirectory($directories);
        }
        elseif(is_array($directories)){
            foreach($directories as $directory)
                $this->createDirectory($directory);
        }
        else{
            $this->abort('Internal Error');
        }

        return $this;
    }

    public function renameDirectory()
    {
        
    }

    public function renameDirectories()
    {
        
    }

    public function removeDirectory()
    {
        
    }

    public function removeDirectories()
    {
        
    }

    /**
     * Add a file to be copied to the filesToCopy array
     *
     * @param string $source
     * @param string $target
     * @return LaravelStorageManager
     */
    public function copyFile($source, $target)
    {
        if(! $this->getDisk()->exists($this->pathCreator($target)) || $this->forceOperation){
            $this->getDisk()->copy($source, $this->pathCreator($target));
        }

        return $this;
    }

    public function copyFiles($files)
    {

    }

    public function moveFile($source, $target)
    {

    }

    public function removeFile($file)
    {
        $this->getDisk()->delete($this->workingDirectory . '/' . $file);
    }

    public function getFile($file)
    {
        return $this->getDisk()->get($this->workingDirectory. '/' .$file);
    }

    /**
     * Returns a list of all files within the current working directory
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->getDisk()->files($this->workingDirectory);
    }

    /**
     * Get the currently selected disk
     *
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected function getDisk(){
        return $this->filesystem->disk($this->disk);
    }

    /**
     * Change the disk
     *
     * @param $disk
     * @return mixed
     */
    public function changeDisk($disk)
    {
        return $this->onDisk($disk);
    }

    /**
     * Change Directory
     *
     * @param $dir
     * @return LaravelStorageManager
     */
    public function changeDirectory($dir)
    {
        return $this->cd($dir);
    }

    /**
     * Change Directory
     *
     * @param $dir
     * @return $this
     */
    public function cd($dir)
    {
        $dir = trim($dir, '/');

        // Prepend a slash if we're already inside the file structure
        if(! empty($this->workingDirectory))
            $dir = '/' . $dir;

        $this->workingDirectory .= $dir;

        if(! $this->getDisk()->exists($this->workingDirectory))
            $this->abort('Directory '.$this->workingDirectory . ' does not exist');

        return $this;
    }

    /**
     * Go back to home directory
     *
     * @return $this
     */
    public function cdHome()
    {
        $this->workingDirectory = '';

        return $this;
    }

    public function goHome()
    {
        return $this->cdHome();
    }

    /**
     * Traverse up directory tree. The number of traversals
     * is determined by the param
     *
     * @param int $multiplier
     * @return $this
     */
    public function cdBack($multiplier = 1)
    {
        for($i = 0 ; $i < $multiplier ; $i++) {

            $wd = $this->workingDirectory;

            if (!empty($wd) && str_contains($wd, '/')) {

                $this->workingDirectory = substr($wd, 0, strrpos($wd, '/'));

            } elseif (!empty($wd)) {

                $this->cdHome();

            }
        }
        return $this;
    }

    /**
     * Alias for cdBack
     *
     * @param int $multiplier
     * @return LaravelStorageManager
     */
    public function goBack($multiplier = 1)
    {
        return $this->cdBack($multiplier);
    }

    /**
     * returns the current working directory as string
     *
     * @return string
     */
    public function printWorkingDirectory()
    {
        return $this->workingDirectory;
    }

    /**
     * Alias for printWorkingDirectory
     *
     * @return string
     */
    public function pwd()
    {
        return $this->printWorkingDirectory();
    }

    /**
     * Helper for getting the current working path with the
     * target directory appended
     *
     * @param $path
     * @return string
     */
    protected function pathCreator($path){

        return $this->workingDirectory . '/' . $path;

    }

    /**
     * @param bool $force
     * @return $this
     */
    public function force($force = true){
        $this->forceOperation = $force;
        return $this;
    }

    /**
     * Resets the StorageManagers state to defaults
     */
    public function resetToDefaultState()
    {
        $this->disk = config('filesystems.default');
        $this->forceOperation = false;
        $this->workingDirectory = '';
    }

    /**
     * For those exceptional situations
     *
     * @param $msg
     * @param int $status
     */
    protected function abort($msg, $status = 500)
    {
        abort($status, $msg);
    }
}