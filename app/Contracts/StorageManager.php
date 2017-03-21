<?php
namespace App\Contracts;

interface StorageManager{

    /*
     * DIRECTORY RELATED
     */
    public function createDirectory($directory);
    public function renameDirectory();
    public function removeDirectory();

    /*
     * FILE RELATED
     */
    public function getFile($file);
    public function removeFile($file);
    public function copyFile($source, $target);
    public function moveFile($source, $target);

    /*
     * OPERATIONAL
     */
    public function changeDisk($disk);
    public function resetToDefaultState();
    public function changeDirectory($directory);

}