<?php

namespace blog\models;

abstract class ArrayExpressible {
    public function toArray() {
        return get_object_vars($this);
    }
}
/**
 * @Entity
 * @Table(name="posts")
 */
class Post extends ArrayExpressible {
	
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $title;
		
		/**
     * @Column(type="integer", length=2)
     */
    private $visits;
		
    /**
     * @Column(type="text")
     */
    private $content;
				
		public function title($value = NULL) 
		{ 
			if (is_null($value))
				return $this->title;
			else
				$this->title = $value;
		}
		
		public function content($value = NULL) 
		{ 
			if (is_null($value))
				return $this->content;
			else
				$this->content = $value;
		}
		
		public function visits($value = NULL) 
		{ 
			if (is_null($value))
				return $this->visits;
			else
				$this->visits = $value;
		}
		
		public function addVisit() { $this->visits++; }
		
}

/* End of file Post.php */
/* Location: ./application/modules/blog/modules/Post.php */