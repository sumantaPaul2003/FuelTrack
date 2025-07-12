<?php
session_start();
include '../../assets/constant/config.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['submit'])) {

        $stmt = $conn->prepare("INSERT INTO `employee`(`employeeName`, `employeeEmail`, `employeePhone`,`employeeAccountNo`, `employeeAddress`, `shift`) VALUES (?,?,?,?,?,?)");

        // Apply htmlspecialchars to user inputs
        $employeeName = htmlspecialchars($_POST['employeeName'], ENT_QUOTES, 'UTF-8');
        $employeeEmail = htmlspecialchars($_POST['employeeEmail'], ENT_QUOTES, 'UTF-8');
        $employeePhone = htmlspecialchars($_POST['employeePhone'], ENT_QUOTES, 'UTF-8');
        $employeeAddress = htmlspecialchars($_POST['employeeAddress'], ENT_QUOTES, 'UTF-8');
        $accountNo = htmlspecialchars($_POST['accountNo'], ENT_QUOTES, 'UTF-8');
        $shift = htmlspecialchars($_POST['shift'], ENT_QUOTES, 'UTF-8');
        
        

        $stmt->execute([$employeeName, $employeeEmail, $employeePhone, $accountNo, $employeeAddress, $shift]);

        $_SESSION['success'] = "success";

        header("location:../manage_employee.php");
    }

    if (isset($_POST['update'])) {

        $stmt = $conn->prepare("UPDATE `employee` SET `employeeName`=?, `employeeEmail`=?, `employeePhone`=?,`employeeAccountNo`=?, `employeeAddress`=?, `shift`=? WHERE id=? ");

        // Apply htmlspecialchars to user inputs
        $employeeName = htmlspecialchars($_POST['employeeName'], ENT_QUOTES, 'UTF-8');
        $employeeEmail = htmlspecialchars($_POST['employeeEmail'], ENT_QUOTES, 'UTF-8');
        $employeePhone = htmlspecialchars($_POST['employeePhone'], ENT_QUOTES, 'UTF-8');
        $employeeAccountNo = htmlspecialchars($_POST['employeeAccountNo'], ENT_QUOTES, 'UTF-8');
        $employeeAddress = htmlspecialchars($_POST['employeeAddress'], ENT_QUOTES, 'UTF-8');
        $shift = htmlspecialchars($_POST['shift'], ENT_QUOTES, 'UTF-8');
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');

        $stmt->execute([$employeeName, $employeeEmail, $employeePhone, $employeeAccountNo, $employeeAddress, $shift, $id]);

        $_SESSION['update'] = "update";
        header("location:../manage_employee.php");
    }

    if (isset($_POST['del_id'])) {

        $stmt = $conn->prepare("UPDATE `employee` SET delete_status='1' WHERE id=? ");

        // Apply htmlspecialchars to user inputs
        $del_id = htmlspecialchars($_POST['del_id'], ENT_QUOTES, 'UTF-8');

        $stmt->execute([$del_id]);

        $_SESSION['delete'] = "delete";

        header("location:../manage_employee.php");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
