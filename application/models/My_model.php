<?php 

defined('BASEPATH') or exit();

class My_model extends CI_Model {

        public function getData($limit, $start, $search_query, $page)
        {
            $output = '';
            $this->db->select('*');
            $this->db->from('user_info');
            $this->db->join('phone_info', 'phone_info.user_id = user_info.id');

            if($search_query !== '')
            {
                $this->db->like('name', $search_query);
                $this->db->or_like('contact_num', $search_query);
            }

            $this->db->order_by('phone_id', 'DESC');
            $this->db->limit($limit, $start);
            $query =  $this->db->get();

            if($query->num_rows() > 0) {

                $i = 1 + (10 * ($page - 1));

                foreach($query->result() as $row)
                {
                    $output .= '
                        <tr>
                            <td>'.$i++.'</td>
                            <td>'.$row->name.'</td>
                            <td>'.$row->contact_num.'</td>
                            <td><a href="#form" data-toggle="modal" class="btn btn-primary" onclick="submit('.$row->phone_id.')">Edit</a><a class="btn btn-danger ml-3" onclick="deleteData('.$row->phone_id.')">Delete</a></td>
                        </tr>
                    ';
                }

            } else {
                $output .=   '<tr>
                                <td colspan="4" >No Data is Found</td>
                            </tr>';
            }

            return $output;
        }

        public function count_all()
        {
            $query = $this->db->get("phone_info");
            return $query->num_rows();
        }

        // public function findByName($name)
        // {
        //     $this->db->select('name');
        //     $this->db->from('user_info');
        //     $this->db->where('name', $name);
        //     return $this->db->get();
        // }

        public function check_name($name)
        {
            $this->db->where('name', $name);
            $this->db->from('user_info');
            $query = $this->db->get();

            if($query->num_rows() > 0){
                return true;
            } else {
                return false;
            }
        }

        public function addData($data)
        {

            if ($this->check_name($data['name']) !== false ) {

                $users = $this->db->get_where('user_info', array('name' => $data['name']))->result_array();

                foreach($users as $user){
                    $user_id = $user['id'];
                
                    $phone_info = array(
                        'contact_num' => $data['contact_num'],
                        'user_id' => $user_id,
                    );
    
                    $this->db->insert('phone_info', $phone_info);
                }

            } else {

                $user_info = array(
                    'name' => $data['name'],
                );
    
                $this->db->insert('user_info', $user_info);
    
                $last_id = $this->db->insert_id();
    
                $phone_info = array(
                    'contact_num' => $data['contact_num'],
                    'user_id' => $last_id,
                );
    
                $this->db->insert('phone_info', $phone_info);
                
            }

        }

        public function getId($id)
        {
            return $this->db
                ->select('*')
                ->from('phone_info')
                ->join('user_info', 'phone_info.user_id = user_info.id')
                ->where('phone_id', $id)
                ->get();

            // return $this->db->get_where($table, $where);
        }

        public function updateData($phone_id, $user_data, $phone_data)
        {
            $phone_info = $this->db
                ->select('*')
                ->from('phone_info')
                ->join('user_info', 'phone_info.user_id = user_info.id')
                ->where('phone_id', $phone_id)
                ->get()
                ->result_array();

            foreach ($phone_info as $info)
            {
                $where_user = array(
                    'id' => $info['id']
                );
    
                $this->db->where($where_user);
                $this->db->update('user_info', $user_data);
    
                $where_phone = array(
                    'phone_id' => $info['phone_id']
                );
    
                $this->db->where($where_phone);
                $this->db->update('phone_info', $phone_data);
            }

        }

        public function deleteData($where, $table)
        {
            $this->db->where($where);
            $this->db->delete($table);
        }

}