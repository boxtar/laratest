<?php
namespace App\Contracts;

interface StorageManager{

    /*
     * DIRECTORY RELATED
     */
    public function createDirectory($directory);
    public function createDirectories($directories);

    public function renameDirectory();
    public function renameDirectories();

    public function removeDirectory();
    public function removeDirectories();

    /*
     * FILE RELATED
     */
    public function copyFile($source, $target);
    public function moveFile($source, $target);
    public function removeFile($file);
    public function getFile($file);

    /*
     * OPERATIONAL
     */
    public function go();
    public function within($directory);
    public function onDisk($disk);

}