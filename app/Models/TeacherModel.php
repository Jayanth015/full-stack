<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['user_id', 'university_name', 'gender', 'year_joined', 'department', 'phone', 'address', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'user_id' => 'required|integer|is_unique[teachers.user_id,id,{id}]',
        'university_name' => 'required|min_length[2]|max_length[100]',
        'gender' => 'required|in_list[male,female,other]',
        'year_joined' => 'required|integer|greater_than[1900]|less_than_equal_to[2024]',
        'department' => 'required|min_length[2]|max_length[100]',
        'phone' => 'required|min_length[10]|max_length[15]',
        'address' => 'required|min_length[10]|max_length[255]'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required',
            'integer' => 'User ID must be an integer',
            'is_unique' => 'User already has a teacher profile'
        ],
        'university_name' => [
            'required' => 'University name is required',
            'min_length' => 'University name must be at least 2 characters',
            'max_length' => 'University name cannot exceed 100 characters'
        ],
        'gender' => [
            'required' => 'Gender is required',
            'in_list' => 'Gender must be male, female, or other'
        ],
        'year_joined' => [
            'required' => 'Year joined is required',
            'integer' => 'Year joined must be an integer',
            'greater_than' => 'Year joined must be after 1900',
            'less_than_equal_to' => 'Year joined cannot be in the future'
        ],
        'department' => [
            'required' => 'Department is required',
            'min_length' => 'Department must be at least 2 characters',
            'max_length' => 'Department cannot exceed 100 characters'
        ],
        'phone' => [
            'required' => 'Phone number is required',
            'min_length' => 'Phone number must be at least 10 digits',
            'max_length' => 'Phone number cannot exceed 15 digits'
        ],
        'address' => [
            'required' => 'Address is required',
            'min_length' => 'Address must be at least 10 characters',
            'max_length' => 'Address cannot exceed 255 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getTeacherWithUser($id = null)
    {
        $builder = $this->db->table('teachers t');
        $builder->select('t.*, u.email, u.first_name, u.last_name');
        $builder->join('auth_user u', 'u.id = t.user_id');
        
        if ($id) {
            $builder->where('t.id', $id);
            return $builder->get()->getRowArray();
        }
        
        return $builder->get()->getResultArray();
    }
}
