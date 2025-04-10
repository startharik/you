<?php
require_once("assets/includes/classes/videoInfoControls.php");
class videoInfoSection{

    private $con, $video, $userLoggedInObj;

    public function __construct($con, $video, $userLoggedInObj){
        $this->con = $con;
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create(){

        return $this->createPrimaryInfo() . $this->createSecondaryInfo();

        
    }

    private function createPrimaryInfo(){
        $title = $this->video->getTitle();
        $views = $this->video->getViews();

        $videoInfoControls = new videoInfoControls($this->video, $this->userLoggedInObj);
        $controls = $videoInfoControls->create();

        return "<div class ='videoInfo'>
                    <h1>$title</h1>

                    <div class ='bottomSection'>
                        <span class ='viewCount'>$views views</span>
                        $controls
                    </div>
                </div>";
    }

    private function createSecondaryInfo(){

        $description =$this->video->getDescription();
        $uploadDate = $this->video->getUploadDate();
        $uploadedBy = $this->video->getUploadedBy();
        $profileButton = buttonProvider::createUserProfileButton($this->con, $uploadedBy);

        if($uploadedBy ==$this->userLoggedInObj->getUsername()){
            $actionButton = buttonProvider::createEditVideoButton($this->video->getId());
        }
        else{
            $userToObject = new user($this->con, $uploadedBy);
            $actionButton = buttonProvider::createSubscriberButton($this->con, $userToObject, $this->userLoggedInObj);
        }

        return "<div class='secondaryInfo'>
                   <div class='topRow'>
                        $profileButton

                        <div class='uploadInfo'>
                            <span class='owner'>
                                <a href='profile.php?username=$uploadedBy'>
                                    $uploadedBy
                                </a>
                            </span>
                            <span class='date'>Published on $uploadDate</span>
                        </div>
                        
                        $actionButton
                   </div>
                        <div class='descriptionContainer'>
                            $description
                        </div>

                </div>";
    }
}




?>