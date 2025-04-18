<?php

class commentSection{

    private $con, $video, $userLoggedInObj;

    public function __construct($con, $video, $userLoggedInObj){
        $this->con = $con;
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create(){
        return $this->createCommentSection();
        
    }

    private function createCommentSection(){
        $numComments = $this->video->getNumberOfComments();
        $postedBy = $this->userLoggedInObj->getUsername();
        $videoId = $this->video->getId();

        $profileButton = buttonProvider::createUserProfileButton($this->con, $postedBy);
        $commentAction = "postComment(this, \"$postedBy\", $videoId, null, \"comments\")";
        $commentButton = buttonProvider::createButton("COMMENT", null, $commentAction, "postComment");

        $comments = $this->video->getComments();
        $commentItems = "";
        foreach($comments as $comment) {
            $commentItems .= $comment->create();
        }

        return "<div class='commentSection'>
                    <div class='header'>
                        <span class='commentCount'>$numComments Comments</span>
                        <div class='commentForm'>
                            $profileButton
                            <textarea class='commentBody' placeholder='Add a Comment'></textarea>
                            $commentButton  
                        </div>  
                    </div> 
                    <div class='comments'>
                    $commentItems
                    </div>

                </div>";
    }

    
}




?>