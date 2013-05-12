<?php

class Nome{
	
	private $objectId;
	
	
	
	private $createdAt;
	private $updatedAt;
	private $ACL;
	
	
	
	public function __construct(){
		
	}
	
	
	//getters
	public function getObjectId(){return $this->objectId;  }
	
	
	public function getCreatedAt(){ return $this->createdAt; }
	public function getUpdatedAt(){ return $this->updatedAt; }
	public function getACL(){return $this->ACL;  }
	
	//setters
	public function setObjectId($objectId){$this->objectId = $objectId;  }
	
	
	public function setCreatedAt(DateTime $createdAt){$this->createdAt = $createdAt;  }
	public function setUpdatedAt(DateTime $updatedAt){$this->updatedAt = $updatedAt;  }
	public function setACL($ACL){ $this->ACL = ACL; }
}