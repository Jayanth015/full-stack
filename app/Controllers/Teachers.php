<?php

namespace App\Controllers;

use App\Models\TeacherModel;
use App\Models\AuthUserModel;
use CodeIgniter\RESTful\ResourceController;

class Teachers extends ResourceController
{
    protected $teacherModel;
    protected $authUserModel;

    public function __construct()
    {
        $this->teacherModel = new TeacherModel();
        $this->authUserModel = new AuthUserModel();
    }

    public function create()
    {
        $rules = [
            'email' => 'required|valid_email|is_unique[auth_user.email]',
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'password' => 'required|min_length[6]',
            'university_name' => 'required|min_length[2]|max_length[100]',
            'gender' => 'required|in_list[male,female,other]',
            'year_joined' => 'required|integer|greater_than[1900]|less_than_equal_to[2024]',
            'department' => 'required|min_length[2]|max_length[100]',
            'phone' => 'required|min_length[10]|max_length[15]',
            'address' => 'required|min_length[10]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $this->db->transStart();

        try {
            // Create user first
            $userData = [
                'email' => $this->request->getPost('email'),
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'password' => $this->authUserModel->hashPassword($this->request->getPost('password'))
            ];

            $userId = $this->authUserModel->insert($userData);

            if (!$userId) {
                throw new \Exception('Failed to create user');
            }

            // Create teacher profile
            $teacherData = [
                'user_id' => $userId,
                'university_name' => $this->request->getPost('university_name'),
                'gender' => $this->request->getPost('gender'),
                'year_joined' => $this->request->getPost('year_joined'),
                'department' => $this->request->getPost('department'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address')
            ];

            $teacherId = $this->teacherModel->insert($teacherData);

            if (!$teacherId) {
                throw new \Exception('Failed to create teacher profile');
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return $this->failServerError('Transaction failed');
            }

            $teacher = $this->teacherModel->getTeacherWithUser($teacherId);

            return $this->respondCreated([
                'status' => 'success',
                'message' => 'Teacher created successfully',
                'data' => $teacher
            ]);

        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->failServerError($e->getMessage());
        }
    }

    public function index()
    {
        $teachers = $this->teacherModel->getTeacherWithUser();
        
        return $this->respond([
            'status' => 'success',
            'data' => $teachers
        ]);
    }

    public function show($id = null)
    {
        $teacher = $this->teacherModel->getTeacherWithUser($id);
        
        if (!$teacher) {
            return $this->failNotFound('Teacher not found');
        }

        return $this->respond([
            'status' => 'success',
            'data' => $teacher
        ]);
    }

    public function update($id = null)
    {
        $teacher = $this->teacherModel->find($id);
        
        if (!$teacher) {
            return $this->failNotFound('Teacher not found');
        }

        $rules = [
            'university_name' => 'min_length[2]|max_length[100]',
            'gender' => 'in_list[male,female,other]',
            'year_joined' => 'integer|greater_than[1900]|less_than_equal_to[2024]',
            'department' => 'min_length[2]|max_length[100]',
            'phone' => 'min_length[10]|max_length[15]',
            'address' => 'min_length[10]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = $this->request->getJSON(true);
        
        if ($this->teacherModel->update($id, $data)) {
            $teacher = $this->teacherModel->getTeacherWithUser($id);
            
            return $this->respond([
                'status' => 'success',
                'message' => 'Teacher updated successfully',
                'data' => $teacher
            ]);
        }

        return $this->failServerError('Failed to update teacher');
    }

    public function delete($id = null)
    {
        $teacher = $this->teacherModel->find($id);
        
        if (!$teacher) {
            return $this->failNotFound('Teacher not found');
        }

        $this->db->transStart();

        try {
            // Delete teacher profile first
            if (!$this->teacherModel->delete($id)) {
                throw new \Exception('Failed to delete teacher profile');
            }

            // Delete user
            if (!$this->authUserModel->delete($teacher['user_id'])) {
                throw new \Exception('Failed to delete user');
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return $this->failServerError('Transaction failed');
            }

            return $this->respond([
                'status' => 'success',
                'message' => 'Teacher deleted successfully'
            ]);

        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->failServerError($e->getMessage());
        }
    }
}
