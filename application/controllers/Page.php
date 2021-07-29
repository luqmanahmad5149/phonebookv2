<?php 

defined('BASEPATH') or exit();

class Page extends CI_Controller {
    function __construct()
    {
        parent::__construct();

        $this->load->model('My_model', 'm');
        $this->load->helper('form');
        $this->load->helper('url');
    }


    public function index()
    {
        $data['title'] = "PhoneBook v2";

        // $data['title'] = $this->m->getData()->result_array();

        $this->load->view('home', $data);
    }

    public function getData()
    {
        // $data = $this->m->getData()->result_array();

        //echo json_encode($data);

        $search_query = '';

        if($this->input->post('query')) 
        {
            $search_query = $this->input->post('query');
        }

        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = "#";
        $config["total_rows"] = $this->m->count_all();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = '</ul>';
        $config["first_tag_open"] = '<li class="page-link">';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"] = '<li class="page-link">';
        $config["last_tag_close"] = '</li>';
        $config["next_link"] = '&gt;';
        $config["next_tag_open"] = '<li class="page-link">';
        $config["next_tag_close"] = '</li>';
        $config["prev_link"] = '&lt;';
        $config["prev_tag_open"] = '<li class="page-link">';
        $config["prev_tag_close"] = '</li>';
        $config["cur_tag_open"] = '<li class="page-item active"><a class="page-link" href="#">';
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = '<li class="page-link">';
        $config["num_tag_close"] = '</li>';
        $config["num_links"] = 1;

        $this->pagination->initialize($config);
        $page = $this->uri->segment(3);
        $start = ($page - 1) * $config["per_page"];

        $output = array(
            'pagination_link' => $this->pagination->create_links(),
            'contact_table' => $this->m->getData($config["per_page"], $start, $search_query, $page),
        );

        echo json_encode($output);
    }

    public function addData()
    {
        $name = $this->input->post('name');
        $contact_num = $this->input->post('contact_num');

        if($name == ''){
            $result['message'] = "Please enter contact name";
        } elseif($contact_num == ''){
            $result['message'] = "Please enter contact number";
        } else {
            $result['message'] = "";

            $data = array(
                'name' => $name,
                'contact_num' => $contact_num,
            );

            $this->m->addData($data);
        }

        echo json_encode($result);
    }

    public function getId()
    {
        $id = $this->input->post('phone_id');
        $data = $this->m->getId($id)->result();

        echo json_encode($data);
    }

    public function updateData()
    {
        $phone_id = $this->input->post('phone_id');
        $name = $this->input->post('name');
        $contact_num = $this->input->post('contact_num');

        if($name == ''){
            $result['message'] = "Please enter contact name";
        } elseif($contact_num == ''){
            $result['message'] = "Please enter contact number";
        } else {
            $result['message'] = "";

            $user_data = array(
                'name' => $name,
            );
            $phone_data = array(
                'contact_num' => $contact_num,
            );

            $this->m->updateData($phone_id, $user_data, $phone_data);
        }

        // $result = array(
        //     'phone_id' => $phone_id,
        //     'name' => $name,
        //     'contact_num' => $contact_num
        // );

        echo json_encode($result);
    }

    public function deleteData()
    {
        $phone_id  = $this->input->post('phone_id');
        $where = array(
            'phone_id' => $phone_id
        );
        $this->m->deleteData($where, 'phone_info');
    }

}