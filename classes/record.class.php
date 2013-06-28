<?php

/* ! \par Info Generali:
 *  \author    Stefano Muscas
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par Info Classe:
 *  \brief     Record Class
 *  \details   Classe dedicata ad un album di brani musicali, pu� essere istanziata solo da Jammer
 *  
 *  \par Commenti:
 *  \warning
 *  \bug
 *  \todo
 *
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=definizioni:properties_classi:record">Descrizione della classe</a>
 *  <a href="http://www.socialmusicdiscovering.com/dokuwiki/doku.php?id=documentazione:api:record">API</a>
 */

//define('CLASS_DIR', './');

class Record {

    private $objectId;
    private $active;
    private $buyLink;
    private $commentators;
    private $comments;
    private $counter;
    private $cover;
    private $coverFile;
    private $description;
    private $duration;
    private $featuring;
    private $fromUser;
    private $genre;
    private $label;
    private $location;
    private $loveCounter;
    private $lovers;
    private $thumbnailCover;
    private $title;
    private $tracklist;
    private $year;
    private $createdAt;
    private $updatedAt;
    private $ACL;

    /**
	* \fn		string getObjectId()
	* \brief	Return the objectId value
	* \return	string
	*/ 								
    public function getObjectId() {
        return $this->objectId;
    }

    /**
	* \fn		BOOL getObjectId()
	* \brief	Return the active value
	* \return	BOOL
	*/ 	
    public function getActive() {
        return $this->active;
    }

	    /**
	* \fn		string getBuyLink()
	* \brief	Return the buyLink value
	* \return	string
	*/ 
    public function getBuyLink() {
        return $this->buyLink;
    }

    /**
	* \fn		array getCommentators()
	* \brief	Return the commentators value,array of objectId of istance of the _User class who commented the song
	* \return	array
	*/ 
    public function getCommentators() {
        return $this->commentators;
    }

    /**
	* \fn		array getComments()
	* \brief	Return the comments value,array of objectId of istance of the Comment class, comments on song
	* \return	array
	*/
    public function getComments() {
        return $this->comments;
    }

   /**
	* \fn		int getCounter()
	* \brief	Return the counter value
	* \return	int
	*/						
    public function getCounter() {
        return $this->counter;
    }

	    /**
	* \fn		string getCover()
	* \brief	Return the cover (path file) value
	* \return	string
	*/ 
    public function getCover() {
        return $this->cover;
    }

	    /**
	* \fn		string getCoverFile()
	* \brief	Return the cover (file) value
	* \return	parseFile
	*/ 
    public function getCoverFile() {
        return $this->coverFile;
    }

    /**
	* \fn		string getDescription()
	* \brief	Return the description value
	* \return	string
	*/ 
	public function getDescription() {
        return $this->description;
    }

    /**
	* \fn		int getDuration()
	* \brief	Return the duration value in second
	* \return	int
	*/									
    public function getDuration() {
        return $this->duration;
    }

    /**
	* \fn		array getFeaturing()
	* \brief	Return the featuring value,array of objectId of istance of the _User class who feat the song
	* \return	array
	*/  			
    public function getFeaturing() {
        return $this->featuring;
    }

	    /**
	* \fn		string getFromUser()
	* \brief	Return the objectId value for the fromUser
	* \return	string
	*/
    public function getFromUser() {
        return $this->fromUser;
    }

	 /**
	* \fn		string getGenre()
	* \brief	Return the genre value 
	* \return	string
	*/
    public function getGenre() {
        return $this->genre;
    }

	/**
	* \fn		string getLabel()
	* \brief	Return the label value
	* \return	string
	*/
    public function getLabel() {
        return $this->label;
    }

	    /**
	* \fn		parseGoPoint getLocation()
	* \brief	Return the location value 
	* \return	parseGoPoint
	*/
    public function getLocation() {
        return $this->location;
    }

    /**
	* \fn		int getLoveCounter()
	* \brief	Return the loveCounter value, number of users who love the song
	* \return	int
	*/ 			
    public function getLoveCounter() {
        return $this->loveCounter;
    }
	
    /**
	* \fn		array getLovers()
	* \brief	Return the lovers value,array of objectId of istance of the _User class who love the song
	* \return	array
	*/
    public function getLovers() {
        return $this->lovers;
    }

	/**
	* \fn		string getThumbnailCover()
	* \brief	Return the thumbnailCover (path file) value
	* \return	string
	*/
    public function getThumbnailCover() {
        return $this->thumbnailCover;
    }

    /**
	* \fn		string getTitle()
	* \brief	Return the title value
	* \return	string
	*/ 									
    public function getTitle() {
        return $this->title;
    }

    /**
	* \fn		array getTracklist()
	* \brief	Return the tracklist value,array of Ids of song
	* \return	array
	*/ 
	public function getTracklist() {
        return $this->tracklist;
    }

	/**
	* \fn		string getYear()
	* \brief	Return the year value
	* \return	string
	*/ 
    public function getYear() {
        return $this->year;
    }

        /**
	* \fn		DateTime getCreatedAt()
	* \brief	Return the Record creation date
	* \return	DateTime
	*/
	public function getCreatedAt() {
		return $this->createdAt;
	}
	
	/**
	* \fn		DateTime getUpdatedAt()
	* \brief	Return the Record modification date
	* \return	DateTime
	*/
	public function getUpdatedAt() {
		return $this->updatedAt;
	}
	
	/**
	* \fn		parseACL getACL()
	* \brief	Return the parseACL object representing the Record ACL 
	* \return	parseACL
	*/
	public function getACL() {
		return $this->ACL;
	}

	/**
	* \fn		void setObjectId($objectId)
	* \brief	Sets the objectId value
	* \param	string
	*/
	public function setObjectId($objectId) {
		$this->objectId = $objectId;
	}

    /**
	* \fn		void setActive($active)
	* \brief	Sets the active  value
	* \param	BOOL
	*/	
    public function setActive($active) {
        $this->active = $active;
    }

	/**
	* \fn		void setBuyLink($buyLink)
	* \brief	Sets the buyLink value
	* \param	string
	*/
    public function setBuyLink($buyLink) {
        $this->buyLink = $buyLink;
    }

    /**
	* \fn		void setCommentators($commentators)
	* \brief	Sets the commentators  value
	* \param	array
	*/ 
    public function setCommentators($commentators) {
        $this->commentators = $commentators;
    }

    /**
	* \fn		void setComments($comments)
	* \brief	Sets the comments  value
	* \param	array
	*/  
    public function setComments($comments) {
        $this->comments = $comments;
    }

    /**
	* \fn		void setCounter($counter)
	* \brief	Sets the counter  value
	* \param	int
	*/   					
    public function setCounter($counter) {
        $this->counter = $counter;
    }

    /**
	* \fn		void setCover($cover))
	* \brief	Sets the cover value
	* \param	string
	*/
	public function setCover($cover) {
        $this->cover = $cover;
    }

	/**
	* \fn		void setCoverFile($coverFile)
	* \brief	Sets the coverFile value
	* \param	string
	*/
    public function setCoverFile($coverFile) {
        $this->coverFile = $coverFile;
    }

	/**
	* \fn		void setDescription($description)
	* \brief	Sets the description value
	* \param	string
	*/
    public function setDescription($description) {
        $this->description = $description;
    }

	    /**
	* \fn		void setDuration($duration)
	* \brief	Sets the counter  value
	* \param	int
	*/
    public function setDuration($duration) {
        $this->duration = $duration;
    }

	     /**
	* \fn		void setFeaturing($featuring)
	* \brief	Sets the featuring  value
	* \param	array
	*/ 	
    public function setFeaturing($featuring) {
        $this->featuring = $featuring;
    }

	    /**
	* \fn		void setFromUser($fromUser)
	* \brief	Sets the fromUser objectId  value
	* \param	string
	*/ 
    public function setFromUser($fromUser) {
        $this->fromUser = $fromUser;
    }

	 /**
	* \fn		void setGenre($genre) 
	* \brief	Sets the genre value
	* \param	string
	*/
    public function setGenre($genre) {
        $this->genre = $genre;
    }

	/**
	* \fn		void setLabel($label) 
	* \brief	Sets the label value
	* \param	string
	*/
    public function setLabel($label) {
        $this->label = $label;
    }

    /**
	* \fn		void setLocation($location) 
	* \brief	Sets the location value
	* \param	parseGeopoint
	*/	
	public function setLocation($location) {
        $this->location = $location;
    }

     /**
	* \fn		void setLovers($lovers)
	* \brief	Sets the lovers  value
	* \param	array
	*/ 	  
    public function setLovers($lovers) {
        $this->lovers = $lovers;
    }

    /**
	* \fn		void setLoveCounter($loveCounter)
	* \brief	Sets the LoveCounter  value
	* \param	int
	*/ 			
    public function setLoveCounter($loveCounter) {
        $this->loveCounter = $loveCounter;
    }

	     /**
	* \fn		void setThumbnailCover($thumbnailCover) 
	* \brief	Sets the thumbnailCover (path file) value
	* \param	string
	*/
    public function setThumbnailCover($thumbnailCover) {
        $this->thumbnailCover = $thumbnailCover;
    }

	     /**
	* \fn		void setTitle($title) 
	* \brief	Sets the title value
	* \param	string
	*/
    public function setTitle($title) {
        $this->title = $title;
    }

	 /**
	* \fn		void setTracklist($tracklist)
	* \brief	Sets the tracklist  value (list of id)
	* \param	array
	*/ 
    public function setTracklist($tracklist) {
        $this->tracklist = $tracklist;
    }

	     /**
	* \fn		void setYear($year) 
	* \brief	Sets the year value
	* \param	string
	*/
    public function setYear($year) {
        $this->year = $year;
    }

	/**
	* \fn		void setCreatedAt($createdAt)
	* \brief	Sets the Song creation date
	* \param	DateTime
	*/
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
	}
	
	/**
	* \fn		void setUpdatedAt($updatedAt)
	* \brief	Sets the Song modification date
	* \param	DateTime
	*/
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
	}
	
	/**
	* \fn		void setACL($ACL)
	* \brief	Sets the parseACL object representing the Song ACL
	* \param	parseACL
	*/
	public function setACL($ACL) {
		 $this->ACL = $ACL;
	}

		/**
	* \fn		string __toString()
	* \brief	Return a printable string representing the Record object
	* \return	string
	*/
    public function __toString() {
        $string = '';
        if ($this->objectId)
            $string .= '[objectId] => ' . $this->objectId . '<br/>';
        if ($this->active)
            $string .= '[active] => ' . $this->active . '<br/>';
        if ($this->buyLink)
            $string .= '[buyLink] => ' . $this->buyLink . '<br/>';
        if ($this->commentators && count($this->commentators > 0)) {
            $string .= '[commentators] => <br/>';
                foreach ($this->commentators as $user) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[user] => " . $user . "<br />";
            }            
        }
        if ($this->comments && count($this->comments > 0)) {
            $string .= '[comments] =><br/>';
                foreach ($this->comments as $comment) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[comment] => " . $comment . "<br />";
            }            
        }
        if ($this->counter)
            $string .= '[counter] => ' . $this->counter . '<br/>';
        if ($this->cover)
            $string .= '[cover] => ' . $this->cover . '<br/>';
        if ($this->coverFile)
            $string .= '[coverFile] => ' . $this->coverFile->_fileName . '<br/>';
        if ($this->description)
            $string .= '[description] => ' . $this->description . '<br/>';
        if ($this->duration)
            $string .= '[duration] => ' . $this->duration . '<br/>';
        if ($this->featuring && count($this->featuring > 0)) {
            $string .= '[featuring] => <br/>';
                foreach ($this->featuring as $user) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[user] => " . $user . "<br />";
            }            
        }
        if ($this->fromUser)
            $string .= '[fromUser] .= > ' . $this->fromUser . '<br/>';
        if ($this->genre)
            $string .= '[genre] .= > ' . $this->genre . '<br/>';
        if ($this->label)
            $string .= '[label] .= > ' . $this->label . '<br/>';
        $parseGeoPoint = $this->getLocation();
        if ($parseGeoPoint->lat != null && $parseGeoPoint->long) {
            $string .= '[location] => ' . $parseGeoPoint->lat . ', ' . $parseGeoPoint->long . '<br />';
            $string .= '[tracklist] = > <br/>';
                foreach ($this->tracklist as $song) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[song] => " . $song . "<br />";
            }            
        }
        if ($this->loveCounter)$string .= '[loveCounter] .= > '.$this->loveCounter .'<br/>';
        if ($this->lovers)$string .= '[lovers] .= > '.$this->lovers .'<br/>';
        if ($this->thumbnailCover)$string .= '[thumbnailCover] .= > '.$this->thumbnailCover .'<br/>';
        if ($this->title)$string .= '[title] .= > '.$this->title .'<br/>';
        if ($this->tracklist && count($this->tracklist > 0)){
            $string .= '[tracklist] = > <br/>';
                foreach ($this->tracklist as $song) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= "[song] => " . $song . "<br />";
            }
        }
        if ($this->year)$string .= '[year] .= > '.$this->year .'<br/>';
        if (($createdAt = $this->getCreatedAt()))
            $string .= '[createdAt] => ' . $createdAt->format('d-m-Y H:i:s') . '<br />';
        if (($updatedAt = $this->getUpdatedAt()))
            $string .= '[updatedAt] => ' . $updatedAt->format('d-m-Y H:i:s') . '<br />';
        if ($this->getACL() != null) {
            foreach ($this->getACL()->acl as $key => $acl) {
                $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $string .= '[key] => ' . $key . '<br />';
                foreach ($acl as $access => $value) {
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $string .= '[access] => ' . $access . ' -> ' . $value . '<br />';
                }
            }
        }
        return $string;
    }

}

?>