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
    protected $disk = 'local';

    /*
     * Force operation
     */
    protected $forceOperation = false;

    /*
     * The base directory to prepend to operations
     * Useful for doing multiple operations within the same directory
     */
    protected $baseDirectory = '';

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

    protected function localDisk(){
        return $this->filesystem->disk('local');
    }

    protected function getDisk(){
        return $this->filesystem->disk($this->disk);
    }

    /*
     * Process all operations
     */
    public function go()
    {
        $this->processCreationOfDirectories();

        $this->processCopyingOfFiles();

        // processMovingOfFiles

        $this->resetState();

        return $this;
    }

    /*
     * Add a directory to the array of directories pending creation
     */
    public function createDirectory($directory)
    {
        if(is_string($directory)) $this->directories[] = $directory;

        return $this;
    }

    /*
     * Add a list of directories to the array of directories pending creation
     *
     * @param array $directories
     * @return LaravelStorageManager
     */
    public function createDirectories($directories)
    {
        if(is_array($directories)){
            foreach($directories as $directory)
                $this->createDirectory($directory);
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
        $this->filesToCopy[$source] = $target;
        return $this;
    }

    public function moveFile($source, $target)
    {

    }

    public function removeFile($file)
    {

    }

    public function getFile($file)
    {
        return $this->getDisk()->get($file);
    }


    public function within($baseDir)
    {
        $this->baseDirectory = $baseDir;
        return $this;
    }

    public function onDisk($disk)
    {
        $this->disk = $disk;
        return $this;
    }

    public function force($force = true){
        $this->forceOperation = $force;
        return $this;
    }

    /**
     * This method creates the directories the user has requested
     * Called from go()
     */
    protected function processCreationOfDirectories()
    {
        if (!empty($this->directories)) {
            foreach ($this->directories as $directory) {
                if (!$this->getDisk()->exists($this->baseDirectory . '/' . $directory) || $this->forceOperation)
                    $this->getDisk()->makeDirectory($this->baseDirectory . '/' . $directory, 0755, true);
            }
            // Operation complete - clear directories
            $this->directories = [];
        }
    }

    /**
     * This method copies the files the user has requested
     * called from go()
     */
    protected function processCopyingOfFiles()
    {
        if (!empty($this->filesToCopy)) {
            foreach ($this->filesToCopy as $source => $target) {
                if(! $this->getDisk()->exists($this->baseDirectory. '/' . $target) || $this->forceOperation)
                    $this->getDisk()->copy($source, $this->baseDirectory . '/' . $target);
            }
            // Operation complete - clear files to be copied
            $this->filesToCopy = [];
        }
    }

    protected function resetState()
    {
        $this->disk = 'local';
        $this->forceOperation = false;
        $this->baseDirectory = '';
    }
}