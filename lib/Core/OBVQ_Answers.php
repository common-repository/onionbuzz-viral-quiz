<?php
namespace OBVQ_WpPluginAutoload\Core;

class OBVQ_Answers{

    private $item_id;
    private $wpdb;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;

        return 1;
    }

    public function getById($id)
    {
        $id = intval($id);
        $results = $this->wpdb->get_row( "SELECT * FROM `{$this->wpdb->prefix}ob_answers` WHERE id = {$id}", ARRAY_A );
        $results = stripslashes_deep($results);
        return $results;
    }
    public function getIDsByQuestionID($question_id){
        $question_id = intval($question_id);
        if($question_id > 0){
            $results = $this->wpdb->get_results( "SELECT id FROM `{$this->wpdb->prefix}ob_answers` WHERE question_id = '{$question_id}' AND flag_published = 1", ARRAY_A );
            $results = stripslashes_deep($results);
        }
        #return json_encode($results);
        return $results;
    }
    public function getAllByQuestionID($question_id, $order = ""){
        $question_id = intval($question_id);
        if($order != ""){
            $order = sanitize_text_field($order);
            $order = "ORDER BY ".$order;
        }
        if($question_id > 0){
            $results['items'] = $this->wpdb->get_results( "SELECT * FROM `{$this->wpdb->prefix}ob_answers` WHERE question_id = '{$question_id}' AND flag_published = 1 {$order}", ARRAY_A );
            $results = stripslashes_deep($results);
        }
        #return json_encode($results);
        return $results;
    }
    public function prevFromId($id, $args = array()){
        $id = intval($id);
        $args['quiz_id'] = intval($args['quiz_id']);
        $args['question_id'] = intval($args['question_id']);
        if(isset($args['quiz_id']) && intval($args['quiz_id'] > 0))
        {
            $and_query = " AND quiz_id = '{$args['quiz_id']}'";
        }
        if(isset($args['question_id']) && intval($args['question_id'] > 0))
        {
            $and_query .= " AND question_id = '{$args['question_id']}'";
        }
        return $results = $this->wpdb->get_row( "SELECT id FROM `{$this->wpdb->prefix}ob_answers` WHERE id < {$id} {$and_query} ORDER BY id DESC LIMIT 1", ARRAY_A );
    }
    public function nextFromId($id, $args = array()){
        $id = intval($id);
        $args['quiz_id'] = intval($args['quiz_id']);
        $args['question_id'] = intval($args['question_id']);
        if(isset($args['quiz_id']) && intval($args['quiz_id'] > 0))
        {
            $and_query = " AND quiz_id = '{$args['quiz_id']}'";
        }
        if(isset($args['question_id']) && intval($args['question_id'] > 0))
        {
            $and_query .= " AND question_id = '{$args['question_id']}'";
        }
        return $results = $this->wpdb->get_row( "SELECT id FROM `{$this->wpdb->prefix}ob_answers` WHERE id > {$id} {$and_query} ORDER BY id ASC LIMIT 1", ARRAY_A );
    }
    public function getAll($query = '', $page = 1, $orderby = '', $ordertype = '', $quiz_id = '', $question_id){
        $question_id = intval($question_id);
        $query_setup = '';
        if($question_id > 0){
            $query_setup .= "AND question_id = '{$question_id}'";
        }
        $results['items'] = $this->wpdb->get_results( "SELECT * FROM `{$this->wpdb->prefix}ob_answers` WHERE 1 $query_setup", ARRAY_A );
        $results = stripslashes_deep($results);

        return json_encode($results);
    }
    public function getQuestionId($id)
    {
        $id = intval($id);
        $results = $this->wpdb->get_row( "SELECT question_id FROM `{$this->wpdb->prefix}ob_answers` WHERE id = {$id}", ARRAY_A );
        $results = stripslashes_deep($results);
        return $results;
    }
    public function getQuizId($id)
    {
        $id = intval($id);
        $results = $this->wpdb->get_row( "SELECT quiz_id FROM `{$this->wpdb->prefix}ob_answers` WHERE id = {$id}", ARRAY_A );
        $results = stripslashes_deep($results);
        return $results;
    }
    public function saveFromString($question_id, $answers_string, $delimeter = ","){
        $answers_array = explode($delimeter, $answers_string);

        $oQuestions = new OBVQ_Questions();
        $quiz_info = $oQuestions->getQuizId($question_id);
        #print_r($quiz_info);
        // clear all answers
        $this->wpdb->delete( $this->wpdb->prefix.'ob_answers', array( 'question_id' => $question_id ), array( '%d' ) );
        // save all answers
        foreach ($answers_array as $k=>$v){
            if(trim($answers_array[$k]) != ''){
                $this->wpdb->insert(
                    $this->wpdb->prefix . 'ob_answers',
                    array(
                        'quiz_id' => intval($quiz_info['quiz_id']),
                        'question_id' => intval($question_id),
                        'title' => sanitize_text_field(trim($answers_array[$k])),
                        'description' => "",
                        'featured_image' => "",
                        'flag_correct' => 1,
                        'flag_published' => 1
                    )
                );
            }

        }
    }
    public function save($item_id = 0, $data){

        $item_id = intval($item_id);
        // if attachment selected, get its wp id
        $attachment_id = intval($data['attachment_id']);

        // the UPDATE
        if($item_id > 0){
            $return['success'] = 0;
            $return['action'] = 'UPDATE answer id:'.$item_id;

            // update question in db
            $this->wpdb->update(
                $this->wpdb->prefix.'ob_answers',
                array(
                    'title' => sanitize_text_field($data['title']),
                    'description' => $data['description'],
                    'featured_image' => sanitize_text_field($data['featured_image']),
                    'flag_correct' => intval($data['flag_correct']),
                    'flag_published' => intval($data['flag_published'])
                ),
                array(
                    'id' => intval($item_id)
                )
            );

            $this->wpdb->delete( $this->wpdb->prefix.'ob_answer2result', array( 'answer_id' => $item_id ), array( '%d' ) );
            foreach($data['result_ids'] as $k=>$v){
                $this->wpdb->insert(
                    $this->wpdb->prefix . 'ob_answer2result',
                    array(
                        'answer_id' => $item_id,
                        'result_id' => intval($data['result_ids'][$k]),
                        'points'    => "{$data['result_points'][$k]}"
                    )
                );
            }

            $return['success'] = 1;
            $return['id'] = $item_id;
            $return['quiz_id'] = $data['quiz_id'];
            $return['question_id'] = $data['question_id'];
        }
        // the INSERT
        else
        {
            $return['success'] = 0;
            $return['action'] = 'INSERT answer. Assign to question:'.$data['question_id'];

            //db add row
            $this->wpdb->insert(
                $this->wpdb->prefix . 'ob_answers',
                array(
                    'quiz_id' => intval($data['quiz_id']),
                    'question_id' => intval($data['question_id']),
                    'title' => sanitize_text_field($data['title']),
                    'description' => $data['description'],
                    'featured_image' => sanitize_text_field($data['featured_image']),
                    'flag_correct' => intval($data['flag_correct']),
                    'flag_published' => intval($data['flag_published'])
                )
            );
            $item_id = $this->wpdb->insert_id;

            if ($item_id > 0) {

                foreach($data['result_ids'] as $k=>$v){
                    $this->wpdb->insert(
                        $this->wpdb->prefix . 'ob_answer2result',
                        array(
                            'answer_id' => $item_id,
                            'result_id' => intval($data['result_ids'][$k]),
                            'points'    => $data['result_points'][$k]
                        )
                    );
                }

                $return['success'] = 1;
                $return['id'] = $item_id;
                $return['quiz_id'] = $data['quiz_id'];
                $return['question_id'] = $data['question_id'];
            }
        }

        return json_encode($return);

    }

    public function delete($item_id){
        $item_id = intval($item_id);
        if($item_id > 0){
            // delete quiz

            $this->wpdb->delete( $this->wpdb->prefix.'ob_answer2result', array( 'answer_id' => $item_id ), array( '%d' ) );
            $this->wpdb->delete( $this->wpdb->prefix.'ob_answers', array( 'id' => $item_id ), array( '%d' ) );

            $return['action'] = 'DELETE';
            $return['success'] = 1;
        }
        else{
            $return['success'] = 0;
        }

        return json_encode($return);

    }
}