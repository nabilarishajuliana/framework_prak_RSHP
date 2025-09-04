<?php
require_once '../model/roleModel.php';

class RoleController
{
    private $model;

    public function __construct()
    {
        $this->model = new Role();
    }

    // Menampilkan semua user dengan role
    public function getUserRole()
    {
        return $this->model->getAllUsersWithRoles();
    }
}
