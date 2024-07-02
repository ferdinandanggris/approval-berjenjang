<?php

function roleBadgeColor($role){
  switch ($role) {
      case 'officer':
          # code...
          return 'bg-primary';
          break;
      case 'hr':
          # code...
          return 'bg-success';
          break;
      case 'finance':
          # code...
          return 'bg-warning';
          break;
      case 'employee':
          # code...
          return 'bg-info';
          break;
      default:
          # code...
          return 'bg-primary';
          break;
  }
}

  function checkIsHaveAccess($auth,$data_approval){
    $isHaveAccess = true;
    if (($data_approval->is_approve_officer == 0 || $data_approval->is_approve_officer == 2)) {
      if ($auth->user()->role == 'officer') {
        $isHaveAccess = true;
      }else{
        $isHaveAccess = false;
      }
    }else if($data_approval->is_approve_hr == 0 || $data_approval->is_approve_hr == 2){
      if ($auth->user()->role == 'hr' || $auth->user()->role == 'officer') {
        $isHaveAccess = true;
      }else{
        $isHaveAccess = false;
      }
    }
    return $isHaveAccess;
  }

  function checkRole($auth, $role){
    if($auth->user()->role == $role){
      return true;
    }
    return false;
  }