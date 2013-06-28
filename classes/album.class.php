<?php
/* ! \par Info Generali:
 *  \author    Maria Laura Fresu
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Album
 *  \details   Classe raccoglitore per immagini
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:album">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:album">API</a>
 */

class Album {

    private $objectId;
    private $active;
    private $commentators;
    private $comments;
    private $counter;
    private $cover;
    private $coverFile;
    private $description;
    private $featuring;
    private $fromUser;
    private $images;
    private $location;
    private $loveCounter;
    private $lovers;
    private $tags;
    private $thumbnailCover;
    private $title;
    private $createdAt;
    private $updatedAt;
    private $ACL;

    /**
     * \fn	string getObjectId()
     * \brief	Return the objectId value
     * \return	string
     */
    public function getObjectId() {
        return $this->objectId;
    }

    /**
     * \fn	BOOL getActive()
     * \brief	Return the active vvalure
     * \return	BOOL
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * \fn	array getCommentators()
     * \brief	Return an array of objectId of istances of _User class who commented on the video
     * \return	array
     */
    public function getCommentators() {
        return $this->commentators;
    }

    /**
     * \fn	array getComments()
     * \brief	Return an array of objectId of istances of the Comment class; comments on the video istance
     * \return	array
     */
    public function getComments() {
        return $this->comments;
    }

	    /**
     * \fn	string getCover()
     * \brief	Return the cover (path file) value
     * \return	string
     */
    public function getCover() {
        return $this->cover;
    }

	    /**
     * \fn	parseFile getCoverFile()
     * \brief	Return the coverFile value
     * \return	parseFile
     */
    public function getCoverFile() {
        return $this->coverFile;
    }

    /**
     * \fn	int getCounter()
     * \brief	Return the counter value
     * \return	int
     */
    public function getCounter() {
        return $this->counter;
    }

    /**
     * \fn	string getDescription()
     * \brief	Return the description value
     * \return	string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * \fn	array getFeaturing()
     * \brief	Return the featuring value, array of objectId to _User istances
     * \return	array
     */
    public function getFeaturing() {
        return $this->featuring;
    }

    /**
     * \fn	string getFromUser()
     * \brief	Return the objectId value for the fromUser
     * \return	string
     */
    public function getFromUser() {
        return $this->fromUser;
    }

	/**
     * \fn	array getImages()
     * \brief	Return the iamges value, array of objectId to Image istances
     * \return	array
     */
    public function getImages() {
        return $this->images;
    }

	 /**
     * \fn	geopoint getLocation()
     * \brief	Return the location  value
     * \return	geopoint
     */
    public function getLocation() {
        return $this->location;
    }

    /**
     * \fn	int getLoveCounter()
     * \brief	Return the int value of loveCounter, counting the love action on the video
     * \return	int
     */
    public function getLoveCounter() {
        return $this->loveCounter;
    }

    /**
     * \fn	array  getLovers()
     * \brief	Return the lovers value, array of objectId to istances of the _User, people ho love the video
     * \return	string
     */
    public function getLovers() {
        return $this->lovers;
    }

    /**
     * \fn	array getTags()
     * \brief	Return the tags value, array of string to categorize the video
     * \return	array
     */
    public function getTags() {
        return $this->tags;
    }
	
	/**
     * \fn	string getThumbnailCover()
     * \brief	Return the thumbnailCover value 
     * \return	string
     */
    public function getThumbnailCover() {
        return $this->thumbnailCover;
    }

    /**
     * \fn	string getTitle()
     * \brief	Return the title value
     * \return	string
     */
    public function getTitle() {
        return $this->title;
    }
    /**
     * \fn	DateTime getCreatedAt()
     * \brief	Return the Album creation date
     * \return	DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * \fn	DateTime getUpdatedAt()
     * \brief	Return the Album modification date
     * \return	DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * \fn	parseACL getACL()
     * \brief	Return the parseACL object representing the Album ACL 
     * \return	parseACL
     */
    public function getACL() {
        return $this->ACL;
    }

    /**
     * \fn	void setObjectId($objectId)
     * \brief	Sets the objectId value
     * \param	string
     */
    public function setObjectId($objectId) {
        $this->objectId = $objectId;
    }

    /**
     * \fn	void setActive($active)
     * \brief	Sets the active value
     * \param	BOOL
     */
    public function setActive($active) {
        $this->active = $active;
    }

    /**
     * \fn	void setCommentators($commentators)
     * \brief	Sets the commentators value,array of pointer to ParseUser
     * \param	array
     */
    public function setCommentators($commentators) {
        $this->commentators = $commentators;
    }

    /**
     * \fn	void setComments($comments)
     * \brief	Sets the comments value,array of pointer to ParseComment
     * \param	array
     */
    public function setComments($comments) {
        $this->comments = $comments;
    }

    /**
     * \fn	void setCounter($counter)
     * \brief	Sets the counter value
     * \param	int
     */
    public function setCounter($counter) {
        $this->counter = $counter;
    }

    /**
     * \fn	void setCover($cover)
     * \brief	Sets the cover value
     * \param	string
     */
    public function setCover($cover) {
        $this->cover = $cover;
    }

	/**
     * \fn	void setCoverFile($coverFile)
     * \brief	Sets the coverFile value
     * \param	parseFile
     */
    public function setCoverFile($coverFile) {
        $this->coverFile = $coverFile;
    }

	    /**
     * \fn	void setDescription($description)
     * \brief	Sets the description value
     * \param	string
     */
    public function setDescription($description) {
        $this->description = $description;
    }

	    /**
     * \fn	void setFeaturing($featuring)
     * \brief	Sets the featuring value,array of pointer to ParseUser
     * \param	array
     */
    public function setFeaturing($featuring) {
        $this->featuring = $featuring;
    }

	 /**
     * \fn	void setFromUser($fromUser))
     * \brief	Sets the fromUser value,pointer to ParseUser
     * \param	string
     */
    public function setFromUser($fromUser) {
        $this->fromUser = $fromUser;
    }

	    /**
     * \fn	void setImages($images)
     * \brief	Sets the images value,array of pointer to Image
     * \param	array
     */
    public function setImages($images) {
        $this->images = $images;
    }

        /**
     * \fn	void setLocation($location)
     * \brief	Sets the location value
     * \param	parseGeopoint
     */
    public function setLocation($location) {
        $this->location = $location;
    }
	
	    /**
     * \fn	void setLoveCounter($loveCounter)
     * \brief	Sets the loveCounter value
     * \param	int
     */
    public function setLoveCounter($loveCounter) {
        $this->loveCounter = $loveCounter;
    }

    /**
     * \fn	void setLovers($lovers)
     * \brief	Sets the lovers value,array of pointer to ParseUser
     * \param	array
     */
    public function setLovers($lovers) {
        $this->lovers = $lovers;
    }

	 /**
     * \fn	void setTags($tags)
     * \brief	Sets the tags value,array of strings
     * \param	array
     */
    public function setTags($tags) {
        $this->tags = $tags;
    }
	
	    /**
     * \fn	void setTitle($title)
     * \brief	Sets the titke value
     * \param	string
     */
    public function setTitle($title) {
        $this->title = $title;
    }

	    /**
     * \fn	void setThumbnailCover($thumbnailCover)
     * \brief	Sets the thumbnailCover value
     * \param	string
     */
    public function setThumbnailCover($thumbnailCover) {
        $this->thumbnailCover = $thumbnailCover;
    }

    /**
     * \fn	void setCreatedAt($createdAt)
     * \brief	Sets the Status creation date
     * \param	DateTime
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    /**
     * \fn	void setUpdatedAt($updatedAt)
     * \brief	Sets the Status modification date
     * \param	DateTime
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    /**
     * \fn	void setACL($ACL)
     * \brief	Sets the parseACL object representing the Status ACL
     * \param	parseACL
     */
    public function setACL($ACL) {
       $this->ACL = $ACL;
    }

		    /**
     * \fn	string __toString()
     * \brief	Return a printable string representing the Album object
     * \return	string
     */
    public function __toString() {
        $string = "";

        if ($this->objectId != null)
            $string .= "[ objectId ] => " . $this->objectId . "</br>";
        else $string .= "[ objectId ] => NULL</br>";
        if (is_bool($this->active)){
            $bool = ($this->active) ? "TRUE" : "FALSE";
            $string .= "[ active ] => " . $bool . "</br>";    
        }
        else $string .= "[ active ] => NULL</br>";
        if ($this->commentators != null && count($this->commentators) > 0) {
            $string .= "[ commentators	] => </br>";
            foreach ($this->commentators as $commentator) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[$commentator] => ' . $commentator . '<br />';
            }
        }
        else $string .= "[ commentators ] => NULL</br>";
        if ($this->comments != null && count($this->comments) > 0) {
            $string .= "[ comments ] => </br>";
            foreach ($this->comments as $comment) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[$comment] => ' . $comment . '<br />';
            }
        }
        else $string .= "[ comments ] => NULL</br>";
        if ($this->counter != null)
            $string .= "[ counter ] => " . $this->counter . "</br>";
        else $string .= "[ counter ] => NULL</br>";
        if ($this->cover != null)
            $string .= "[ cover	] => " . $this->cover . "</br>";
        else $string .= "[ cover ] => NULL</br>";
        if ($this->coverFile != null)
            $string .= "[ coverFile ] => " . $this->coverFile->_fileName . "</br>";
        else $string .= "[ coverFile ] => NULL</br>";
        if ($this->description != null)
            $string .= "[ description ] => " . $this->description . "</br>";
        else $string .= "[ description ] => NULL</br>";
        if ($this->featuring != null && count($this->featuring) > 0) {
            $string .= "[ featuring ] => </br>";
            foreach ($this->featuring as $user) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[featuring] => ' . $user . '<br />';
            }            
        }
        else $string .= "[ featuring ] => NULL</br>";
        if ($this->fromUser != null)
            $string .= "[ fromUser ] => " . $this->fromUser . "</br>";
        else $string .= "[ fromUser ] => NULL</br>";
        
        if ($this->images != null) {
            $string .= "[ images ] =></br>";
            foreach ($this->images as $image) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[image] => ' . $image . '<br />';
            }             
        }
        else $string .= "[ images ] => NULL</br>";
        if ( ($geopoint = $this->location) != null)
            $string .= "[location] => " . $geopoint->location['latitude'] . ", " . $geopoint->location['longitude'] . "<br />";
        else $string .= "[ location ] => NULL</br>";
        if ($this->loveCounter != null)
            $string .= "[ loveCounter ] => " . $this->loveCounter . "</br>";
        else $string .= "[ loveCounter ] => NULL</br>";
        if ($this->lovers != null && count($this->lovers) > 0) {
            $string .= "[ lovers ] => </br>";
            foreach ($this->lovers as $lover) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[lover] => ' . $lover . '<br />';
            }              
        }
        else $string .= "[ lovers ] => NULL</br>";

        if ($this->tags != null && count($this->tags) > 0) {
            $string .= "[ tags ] => </br>";
            foreach ($this->tags as $tag) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[tag] => ' . $tag . '<br />';
            }             
        }
        else $string .= "[ tags ] => NULL</br>";

        if ($this->thumbnailCover != null)
            $string .= "[ thumbnailCover ] => " . $this->thumbnailCover . "</br>";
        else $string .= "[ thumbnailCover ] => NULL</br>";
        if ($this->title != null)
            $string .= "[ title	] => " . $this->title . "</br>";
        else $string .= "[ title ] => NULL</br>";
        if ($this->createdAt != null)
            $string .= "[ createdAt ] => " . $this->createdAt->format('d/m/Y H:i:s') . "</br>";
        else $string .= "[ createdAt ] => NULL</br>";
        if ($this->updatedAt != null)
            $string .= "[ updatedAt ] => " . $this->updatedAt->format('d/m/Y H:i:s') . "</br>";
        else $string .= "[ updatedAt ] => NULL</br>";
        if ($this->ACL != null) {
            $string .= "[ ACL ] => </br>";
            foreach ($this->ACL->acl as $key => $acl) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[key] => ' . $key . '<br />';
                foreach ($acl as $access => $value) {
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '[access] => ' . $access . ' -> ' . $value . '<br />';
                }
            }
        }
        else $string .= "[ ACL ] => NULL</br>";
        return $string;
    }

}

?>