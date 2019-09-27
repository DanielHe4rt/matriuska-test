<?php
/**
 * Created by PhpStorm.
 * User: Daniel Reis
 * Date: 26-Sep-19
 * Time: 21:31
 */

namespace App\Entities;


class SortCollection
{
    public $emails;
    public $folders;

    public $rootFolders;
    public function __construct(string $email)
    {
        $this->emails = new Email($email);
        $this->folders = new Folder($email);
    }

    public function getResult(){
        $this->emails->load();
        $this->folders->load();

        $this->setFolderSize();
        $this->getRootFolders();

        dd($this->result());


        return true;
    }

    public function setFolderSize(){
        foreach($this->emails as $email){
            $folderIndex = $this->getFolderIndex($email->folderId);
            $this->folders[$folderIndex]->size += $email->size;
        }
    }

    public function getFolderIndex($emailFolderId){
        foreach($this->folders as $key => $folder){
            if($folder->id == $emailFolderId){
                return $key;
            }
        }
    }

    public function getRootFolders(){
        $aux = [];
        foreach($this->folders as $folder){
            if($folder->parentId == 0){
                $aux[] = $folder;
            }
        }
        $this->rootFolders = $aux;
        return $aux;
    }

    public function getRootParent($folder){
        if($folder->parentId !== 0){
            $aux = array_search($folder->parentId, array_column($this->folders->getArrayCopy(),'id'));
            return $this->getRootParent($this->folders[$aux]);
        }
        return $folder;
    }

    public function getFolderId($folder){
        foreach($this->folders as $key => $value){
            if($folder->id == $value->id){

                return $value;
            }
        }
    }

    public function result(){

        foreach($this->folders as $folder){
            if($folder->parentId === 0){
                continue;
            }

            $rootFolder = $this->getRootParent($folder);
            $index = array_search($rootFolder,(array)$this->rootFolders,true);
            $this->rootFolders[$index]->size += $folder->size;
        }

        return $this->rootFolders;
    }
}
