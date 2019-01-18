<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use blog\models\Post;

class PostManager extends My_DModel {

    function __construct() {
        parent::__construct();

        $this->init('blog\models\Post', $this->doctrine->em);
    }

    public function install()
    {
        try {
            $this->doctrine->tool->createSchema(array($this->em->getClassMetadata($this->entity)));
        } catch(Exception $err) {
            log_message("error", $err->getMessage(), false);
            return false;
        }

        return true;
    }

    public function create($data, $id = null)
    {
        // Create new post
        if (empty($id)) {
            $post = new Post;
        } else {
            $post = $this->get($id);
        }

        $post->title($data['title']);
        $post->content($data['content']);
        $post->visits(0);

        // Save post in db
        $this->save($post);

        return true;
    }

    public function find($id)
    {
        // Find post
        $post = $this->get($id);
        echo "<pre>";
        print_r($this->findByIdThenReturnArray($id));
        if (empty($post)) {
            return false;
        }
        // Show post
//        if ($post) {
//            $post->addVisit();
//            $this->save($post);
//        }

        return $post;
    }

    public function remove($id)
    {
        // Remove post
        if (empty($id)) {
           return false;
        }

        $this->delete($id);

        return true;
    }

}