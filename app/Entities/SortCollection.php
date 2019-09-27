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

        $sortedFolders = $this->getSortedFolders();
        $sortedEmails = $this->getFolderedMailsBySize();

        return $this->getFoldersBySize($sortedFolders,$sortedEmails);
    }

    public function getSortedFolders(){
        $folderAux = [];
        foreach($this->folders as $folder){
            if(!array_key_exists($folder->parentId,$folderAux)){
                $folderAux[$folder->parentId][] = $folder->id;
                continue;
            }
            $folderAux[$folder->parentId][] = $folder->id;
        }
        $this->rootFolders = $folderAux[0];
        unset($folderAux[0]);
        return $folderAux;
    }

    public function getFolderedMailsBySize(){
        $emailAux = [];

        foreach($this->emails as $email){
            if(!array_key_exists($email->folderId,$emailAux)){
                $emailAux[$email->folderId]['size'] = $email->size;
                continue;
            }
            $emailAux[$email->folderId]['size'] += $email->size;
        }

        return $emailAux;
    }

    public function getFoldersBySize($folders,$sizedMails){
        $result = [];
        foreach($this->rootFolders as $value){
            if(!in_array($value,$result)){
                $result[$value] = $sizedMails[$value]['size'];
                continue;
            }
            $result[$value] += $sizedMails[$value]['size'];
        }
        foreach($folders as $folderKey => $folder){
            foreach ($folder as $value){
                $result[$folderKey] += $sizedMails[$value]['size'];
            }
        }

        arsort($result);
        $resultSocorro = [];
        foreach($result as $key => $value){
            $resultSocorro[] = $key;
        }

        return $resultSocorro;
    }

}
